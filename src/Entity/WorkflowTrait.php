<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 07:00 م
 */

namespace Proxima\JobQueue\Entity;


use Doctrine\ORM\Mapping as ORM;

trait WorkflowTrait
{
    #[ORM\Column(type:"integer", nullable:true)]
    private $state;

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }


}