<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 11:48 ص
 */

namespace Proxima\JobQueue\Handler;


use Proxima\JobQueue\Message\TaskFailedMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskFailedHandler implements MessageHandlerInterface
{
    public function __invoke(TaskFailedMessage $taskFailedMessage)
    {
        echo PHP_EOL;
        echo $taskFailedMessage->getException()->getMessage();
        echo PHP_EOL;
    }
}