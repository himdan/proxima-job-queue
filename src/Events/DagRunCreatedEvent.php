<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 09:12 م
 */

namespace Proxima\JobQueue\Events;


use Symfony\Contracts\EventDispatcher\Event;

class DagRunCreatedEvent extends Event
{
    private $dagRunId;

    /**
     * DagRunCreatedEvent constructor.
     * @param $dagRunId
     */
    public function __construct($dagRunId)
    {
        $this->dagRunId = $dagRunId;
    }


}