<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 09:56 م
 */

namespace Proxima\JobQueue\Message;


class TaskStateMessage
{
    private $taskRunId;

    /**
     * TaskStateMessage constructor.
     * @param $taskRunId
     */
    public function __construct($taskRunId)
    {
        $this->taskRunId = $taskRunId;
    }

    /**
     * @return mixed
     */
    public function getTaskRunId()
    {
        return $this->taskRunId;
    }



}