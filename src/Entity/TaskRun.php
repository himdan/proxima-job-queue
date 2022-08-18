<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 07:10 م
 */

namespace Proxima\JobQueue\Entity;


use Proxima\JobQueue\Task;

class TaskRun implements Task
{
    use IdentityTrait;
    use TimestampTrait;
    use WorkflowTrait;
    use RunTimeTrait;
    /**
     * @var ?DagRun $dagRun
     */
    private $dagRun;

    private $taskId;

    private $serviceId;

    /**
     * TaskRun constructor.
     * @param $dagRun
     */
    public function __construct($dagRun)
    {
        $this->dagRun = $dagRun;
    }

    public function getDagRun(): ?DagRun
    {
        return $this->dagRun;
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    /**
     * @param mixed $serviceId
     * @return TaskRun
     */
    public function setServiceId($serviceId):self
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    public function getTaskId(): string
    {
       return $this->taskId;
    }


}