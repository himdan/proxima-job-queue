<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 06:57 م
 */

namespace Proxima\JobQueue\Entity;


use Doctrine\ORM\Mapping as ORM;

trait TimestampTrait
{
    /**
     * @var ?\DateTimeInterface
     */
    #[ORM\Column(type:"datetime", nullable:true)]
    private $createdAt;
    /**
     * @var ?\DateTimeInterface
     */
    #[ORM\Column(type:"datetime", nullable:true)]
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }


}