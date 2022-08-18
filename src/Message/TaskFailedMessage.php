<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 09:56 م
 */

namespace Proxima\JobQueue\Message;


class TaskFailedMessage extends TaskStateMessage
{
    /**
     * @var \Exception $exception
     */
    private $exception;

    public function __construct($taskRunId, \Exception $exception)
    {
        parent::__construct($taskRunId);
        $this->exception = $exception;

    }


}