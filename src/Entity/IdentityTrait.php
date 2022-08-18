<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 06:56 م
 */

namespace Proxima\JobQueue\Entity;


trait IdentityTrait
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}