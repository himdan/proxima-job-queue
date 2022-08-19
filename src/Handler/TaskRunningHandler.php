<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 11:51 ص
 */

namespace Proxima\JobQueue\Handler;


use Proxima\JobQueue\Message\TaskRunningMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskRunningHandler implements MessageHandlerInterface
{
    public  function  __invoke(TaskRunningMessage $taskRunningMessage)
    {
        echo PHP_EOL;
        echo  sprintf('task with id %s is in Running state', $taskRunningMessage->getTaskRunId());
        echo PHP_EOL;
    }
}