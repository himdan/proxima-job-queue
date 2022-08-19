<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 09:36 م
 */

namespace Proxima\JobQueue\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Proxima\JobQueue\Entity\DagRun;
use Proxima\JobQueue\Entity\TaskRun;
use Proxima\JobQueue\Task;

class TaskManager
{
    const Queued = -1;
    const STATE_SUCCESS = 0;
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * TaskManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function findTaskRun($taskRunId)
    {
        return $this->entityManager->find(TaskRun::class, $taskRunId);
    }

    /**
     * @param $dagRunId
     * @return \Generator
     */

    public function getTaskRunsByDagId($dagRunId)
    {
        foreach ($this->entityManager->getRepository(TaskRun::class)->findBy(['dagRun' => $dagRunId]) as $taskRun) {
            yield $taskRun;
        }
    }

    public function isRunnable(TaskRun $taskRun)
    {
        return in_array($taskRun->getState(), [self::Queued]);
    }

    public function updateState(TaskRun $taskRun, $state)
    {
        $taskRun->setState($state);
        $this->entityManager->flush();
    }

    /**
     * @param Task[] $tasks
     * @param TaskRun $taskRun
     */
    public function enQueueTasks($tasks, $taskRun)
    {
        $dagRun = $taskRun->getDagRun();
        $this->push($tasks, $dagRun);

    }

    public function push($tasks, DagRun $dagRun)
    {
        $taskIds = array_map(function (Task $task) {
            return $task->getTaskId();
        }, $tasks);
        $taskRuns = $dagRun->getTaskRuns()->filter(function (Task $taskRun) use ($taskIds) {
            return in_array($taskRun->getTaskId(), $taskIds);
        });
        /**
         * @var TaskRun $taskRun
         */
        foreach ($taskRuns as $taskRun) {
            $taskRun->setState(self::Queued);
        }
        if(null === $dagRun->getState()){
            $dagRun->setState(self::Queued);
        }

        $this->entityManager->flush();
    }
}