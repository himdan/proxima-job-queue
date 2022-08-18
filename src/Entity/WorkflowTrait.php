<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 07:00 م
 */

namespace Proxima\JobQueue\Entity;


trait WorkflowTrait
{
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