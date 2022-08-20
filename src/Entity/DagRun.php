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
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class DagRun implements Dag
{
    use IdentityTrait;
    use TimestampTrait;
    use WorkflowTrait;
    use RunTimeTrait;

    /**
     * @var ArrayCollection|Collection|array
     */
    #[ORM\OneToMany(targetEntity:TaskRun::class, mappedBy:"dagRun")]
    private $tasks;

    /**
     * @var string
     */
    #[ORM\Column(type:"string",nullable:true)]
    private $dagId;
    /**
     * @var ?DagInstance $dagInstance
     */
    #[ORM\ManyToOne(targetEntity:DagInstance::class)]
    private $dagInstance;

    /**
     * DagRun constructor.
     */
    public function __construct(DagInstance $dagInstance)
    {
        $this->dagInstance = $dagInstance;
        $this->tasks = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
    }

    public function getDagId()
    {
        return $this->dagId;
    }

    public function getTasks(): array
    {
        return $this->tasks->toArray();
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


    public function addTask(TaskRun $taskRun)
    {
        if(!$this->tasks->contains($taskRun)){
            $this->tasks->add($taskRun);
        }
    }

    /**
     * @return mixed
     */
    public function getDagInstance()
    {
        return $this->dagInstance;
    }

    /**
     * @param $dagInstance
     * @return DagRun
     */
    public function setDagInstance($dagInstance): self
    {
        $this->dagInstance = $dagInstance;
        return $this;
    }

    public function setState($state): void
    {
        $this->state = $state;
        $this->setUpdatedAt(new \DateTime());
    }


}