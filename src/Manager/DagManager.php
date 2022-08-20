<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 08:32 م
 */

namespace Proxima\JobQueue\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Proxima\JobQueue\Entity\DagRun;
use Proxima\JobQueue\Entity\TaskRun;
use Proxima\JobQueue\Events\DagRunCreatedEvent;
use Proxima\JobQueue\Events\RunDagRunEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DagManager
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var TaskManager
     */
    private $taskManager;

    /**
     * @var DagInstanceManager
     */
    private $dagInstanceManager;

    /**
     * DagManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param EventDispatcherInterface $eventDispatcher
     * @param ContainerInterface $container
     * @param DagInstanceManager $dagInstanceManager
     * @param TaskManager $taskManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher,
        ContainerInterface $container,
        DagInstanceManager $dagInstanceManager,
        TaskManager $taskManager)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->container = $container;
        $this->dagInstanceManager = $dagInstanceManager;
        $this->taskManager = $taskManager;
    }

    public function createDagInstance(DagInterface $dag)
    {
        $dagInstance = $this->dagInstanceManager->makeDagInstance($dag);
        $this->entityManager->persist($dagInstance);
        $dagRun = new DagRun($dagInstance);
        $dagRun->setDagId($dag->getDagId());
        $this->entityManager->persist($dagRun);
        foreach ($dag->getTasks() as $task) {
            $taskRun = new TaskRun($dagRun);
            $taskRun->setServiceId($task->getServiceId());
            $taskRun->setTaskId($task->getTaskId());
            $dagRun->addTask($taskRun);
            $this->entityManager->persist($taskRun);
        }
        $this->entityManager->flush();
        $this->eventDispatcher->dispatch(
            new DagRunCreatedEvent($dagRun->getId()
            ));
        return $dagRun;
    }

    public function next(TaskRun $taskRun, $upstream = null)
    {
        $dagRun = $taskRun->getDagRun();
        $tasks = $this
            ->getDagAsService($dagRun->getDagId())
            ->next($taskRun->getTaskId());
        $this->taskManager->enQueueTasks($tasks, $taskRun);
        $this->eventDispatcher->dispatch(
            new RunDagRunEvent($dagRun->getId(), $upstream)
        );


    }


    public function run(DagRun $dagRun)
    {
        $dagService = $this->getDagAsService($dagRun->getDagId());
        $tasks = $dagService->firstTasks();
        $this->taskManager->push($tasks, $dagRun);
        $this->eventDispatcher->dispatch(
            new RunDagRunEvent($dagRun->getId())
        );
    }

    public function isRunnable(DagRun $dagRun): bool
    {
        return in_array($dagRun->getState(), [null]);
    }

    public function findDagRunById($id): ?DagRun
    {
        return $this->entityManager->find(DagRun::class, $id);
    }

    private function getDagAsService($dagId): DagInterface
    {
        return $this->container->get($dagId);
    }


}