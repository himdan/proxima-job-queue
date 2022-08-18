<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 10:06 م
 */

namespace Proxima\JobQueue\Handler;


use Proxima\JobQueue\Entity\TaskRun;
use Proxima\JobQueue\Manager\DagManager;
use Proxima\JobQueue\Manager\TaskManager;
use Proxima\JobQueue\Message\TaskSuccessMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskSuccessHandler implements  MessageHandlerInterface
{
    /**
     * @var TaskManager
     */
    private $taskManager;
    /**
     * @var DagManager
     */
    private $dagManager;

    /**
     * TaskSuccessHandler constructor.
     * @param TaskManager $taskManager
     * @param DagManager $dagManager
     */
    public function __construct(TaskManager $taskManager, DagManager $dagManager)
    {
        $this->taskManager = $taskManager;
        $this->dagManager = $dagManager;
    }


    public function __invoke(TaskSuccessMessage $successMessage)
    {
        $taskRun = $this->taskManager->findTaskRun($successMessage->getTaskRunId());
        if(!$taskRun instanceof TaskRun){
            return;
        }
        $this->taskManager->updateState($taskRun, TaskManager::STATE_SUCCESS);
        $this->dagManager->next(
            $taskRun,
            $successMessage->getUpstream());


    }
}