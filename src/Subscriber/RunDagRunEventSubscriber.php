<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 11:33 ص
 */

namespace Proxima\JobQueue\Subscriber;


use Doctrine\ORM\EntityManagerInterface;
use Proxima\JobQueue\Entity\TaskRun;
use Proxima\JobQueue\Events\RunDagRunEvent;
use Proxima\JobQueue\Manager\TaskManager;
use Proxima\JobQueue\Triggers\TaskRunTrigger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class RunDagRunEventSubscriber implements EventSubscriberInterface
{


    /**
     * RunDagRunEventSubscriber constructor.
     * @param MessageBusInterface $messageBus
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(MessageBusInterface $messageBus, EntityManagerInterface $entityManager)
    {
        $this->messageBus = $messageBus;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
          RunDagRunEvent::class => ['dispatch'],
        ];
    }

    /**
     * @var MessageBusInterface
     */
    private $messageBus;
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;




    public function dispatch(RunDagRunEvent $event){
        /**
         * @var TaskRun[] $taskRuns
         */
        $taskRuns = $this->entityManager->getRepository(TaskRun::class)->findBy(
            [
                'dagRun' => $event->getDagRunId(),
                'state'=> TaskManager::Queued
            ]
        );

        foreach ($taskRuns as $taskRun){
            $this->messageBus->dispatch(
                new TaskRunTrigger($taskRun->getId())
            );
        }

    }










}