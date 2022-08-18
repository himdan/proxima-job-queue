<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 06:56 م
 */

namespace Proxima\JobQueue\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Proxima\JobQueue\Dag;

class DagRun implements Dag
{
    use IdentityTrait;
    use TimestampTrait;
    use WorkflowTrait;
    use RunTimeTrait;

    /**
     * @var ArrayCollection|Collection|array
     */
    private $tasks;

    private $dagId;

    /**
     * DagRun constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getDagId()
    {
        return $this->dagId;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @return array|ArrayCollection|Collection|TaskRun[]
     */
    public function getTaskRuns()
    {
        return $this->tasks;
    }

    public function setDagId($dagId): self
    {
        $this->dagId = $dagId;
        return $this;
    }




}