<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 11:40 م
 */

namespace Proxima\JobQueue\Triggers;


class TaskRunTrigger
{
    private $taskRunId;

    /**
     * TaskRunMessage constructor.
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