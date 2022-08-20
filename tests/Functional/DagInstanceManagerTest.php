<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 21/08/22
 * Time: 04:12 م
 */

namespace Proxima\JobQueue\Tests\Functional;


use Doctrine\ORM\EntityManagerInterface;
use Proxima\JobQueue\Entity\DagInstance;
use Proxima\JobQueue\Manager\DagInstanceManager;
use Proxima\JobQueue\Tests\Dags\Etl;

class DagInstanceManagerTest extends BaseTestCase
{

    /**
     * @var DagInstanceManager
     */
    private $dagInstanceManager;
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;
    /**
     * @var Etl
     */
    private $etl;

    protected function setUp(): void
    {
        $this->createClient();
        $this->importDatabaseSchema();
        $this->entityManager = self::$kernel->getContainer()->get('test.entity_manager');
        $this->dagInstanceManager = self::$kernel->getContainer()->get(DagInstanceManager::class);
        $this->etl = self::$kernel->getContainer()->get(Etl::class);
    }

    public function testMakePersistentDagInstanceFromClassName()
    {
        $dagInstance = $this->dagInstanceManager->makePersistentDagInstance(Etl::class);
        $this->assertInstanceOf(DagInstance::class, $dagInstance);
        $this->assertNotNull($dagInstance->getId());
    }

    public function testSingleDagInstancePerDag()
    {
        $this->dagInstanceManager->makePersistentDagInstance(Etl::class);
        $this->dagInstanceManager->makePersistentDagInstance(Etl::class);
        $instances = $this
            ->entityManager
            ->getRepository(DagInstance::class)
            ->findBy(['dagId' => Etl::class])
        ;
        $this->assertCount(1, $instances);

    }

    public function testMakePersistentDagInstanceFromServiceInstance()
    {
        $dagInstance = $this->dagInstanceManager->makePersistentDagInstance($this->etl);
        $this->assertInstanceOf(DagInstance::class, $dagInstance);
        $this->assertNotNull($dagInstance->getId());
    }

}