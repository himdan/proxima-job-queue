<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 21/08/22
 * Time: 09:59 ص
 */

namespace Proxima\JobQueue\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Proxima\JobQueue\Attributes\Retry;
use Proxima\JobQueue\Attributes\RunTime;
use Proxima\JobQueue\Attributes\Scheduled;
use Proxima\JobQueue\Entity\DagInstance;

class DagInstanceManager
{

    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * DagInstanceManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function isDag($className): bool
    {
        $reflectionClass = new \ReflectionClass($className);
        return $reflectionClass->implementsInterface(DagInterface::class);
    }

    public function makeDagInstance($className)
    {
        if (null !== ($dagInstance = $this->getDagInstance($className))) {
            return $dagInstance;
        }
        $dagInstance = $this->getDagInstance($className) ? $this->getDagInstance($className) : new DagInstance(self::normalizeClassName($className));
        return $this->createDagInstance($className, $dagInstance);
    }


    public function makePersistentDagInstance($className)
    {
        $dagInstance = $this->makeDagInstance($className);
        if (null === $dagInstance->getId()) {
            $this->entityManager->persist($dagInstance);
        }
        $this->entityManager->flush();
        return $dagInstance;
    }

    private function getDagInstance($className): ?DagInstance
    {
        $className = self::normalizeClassName($className);
        return $this->entityManager->getRepository(DagInstance::class)->findOneBy([
            'dagId' => $className
        ]);
    }

    private static function normalizeClassName($className): string
    {
        return is_object($className) ? get_class($className) : $className;
    }

    private function createDagInstance($className, DagInstance $dagInstance)
    {
        $reflectionClass = new \ReflectionClass($className);
        foreach ($reflectionClass->getAttributes() as $attribute) {
            $this->handleSingleAttribute($dagInstance, $attribute);
        }
        return $dagInstance;
    }

    /**
     * @param DagInstance $dagInstance
     * @param $attribute
     */
    private function handleSingleAttribute(DagInstance $dagInstance, $attribute)
    {
        $attrHandlers = [
            Scheduled::class => function (DagInstance $dagInstance, $attribute) {
                $attr = $attribute->newInstance();
                $dagInstance->setScheduledFor($attr->for);
                $dagInstance->setScheduledCatchup($attr->catchup);
            },
            Retry::class => function (DagInstance $dagInstance, $attribute) {
                $attr = $attribute->newInstance();
                $dagInstance->setRetryOnFail($attr->onFail);
                $dagInstance->setRetryTimes($attr->times);
                $dagInstance->setRetryPreRetryCallback($attr->preRetryCallback);
            },
            RunTime::class => function (DagInstance $dagInstance, $attribute) {
                $attr = $attribute->newInstance();
                $dagInstance->setRuntimeDebug($attr->debug);
                $dagInstance->setRuntimeMaxTimeout($attr->maxTimeout);
            }
        ];
        if (array_key_exists($attribute->getName(), $attrHandlers)) {
            $attrHandlers[$attribute->getName()]($dagInstance, $attribute);
        }
    }
}