<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 09:24 م
 */

namespace Proxima\JobQueue\Runner;

use Proxima\JobQueue\Entity\TaskRun;
use Proxima\JobQueue\Manager\TaskManager;
use Proxima\JobQueue\Message\TaskFailedMessage;
use Proxima\JobQueue\Message\TaskRunningMessage;
use Proxima\JobQueue\Message\TaskSuccessMessage;
use Proxima\JobQueue\Triggers\TaskRunTrigger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class TaskRunHandler implements MessageHandlerInterface
{
    /**
     * @var TaskManager
     */
    private  $taskManager;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * TaskRunCommand constructor.
     * @param TaskManager $taskManager
     * @param ContainerInterface $container
     * @param MessageBusInterface $bus
     */
    public function __construct(TaskManager $taskManager, ContainerInterface $container, MessageBusInterface $bus)
    {
        $this->taskManager = $taskManager;
        $this->container = $container;
        $this->bus = $bus;
    }


    public function __invoke(TaskRunTrigger $message)
    {
        $taskRunId = $message->getTaskRunId();
        /**
         * @var TaskRun $taskRun
         */
        $taskRun = $this->taskManager->findTaskRun($taskRunId);
        if(!$taskRun || !$this->taskManager->isRunnable($taskRun)){
            return;
        }

        $taskService = $this->container->get($taskRun->getServiceId());
        if(!$taskService || !is_callable($taskService)){
            return;
        }
        try{
            $this->bus->dispatch(new TaskRunningMessage($taskRun->getId()));
            $upstream = $taskService();
            $this->bus->dispatch(new TaskSuccessMessage(
                $taskRun->getId(),
                $upstream
            ));
        }catch (\Exception $exception){
            $this->bus->dispatch(new TaskFailedMessage(
                $taskRun->getId(),
                $exception
                ));

        }





    }


}