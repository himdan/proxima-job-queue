<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 07:02 م
 */

namespace Proxima\JobQueue\Entity;


trait RunTimeTrait
{
    /**
     * @var ?\DateTimeInterface $startAt
     */
    private $startAt;
    /**
     * @var  ?\DateTimeInterface $endAt
     */
    private $endAt;

    /**
     * @return mixed
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * @param mixed $startAt
     */
    public function setStartAt($startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * @return mixed
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * @param mixed $endAt
     */
    public function setEndAt($endAt): void
    {
        $this->endAt = $endAt;
    }

}