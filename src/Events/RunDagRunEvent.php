<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 11:13 م
 */

namespace Proxima\JobQueue\Events;

use Symfony\Contracts\EventDispatcher\Event;

class RunDagRunEvent extends Event
{
    private $dagRunId;
    private $upstream;

    /**
     * RunDagRunEvent constructor.
     * @param $dagRunId
     * @param $upstream
     */
    public function __construct($dagRunId, $upstream=null)
    {
        $this->dagRunId = $dagRunId;
        $this->upstream = $upstream;
    }

    /**
     * @return mixed
     */
    public function getDagRunId()
    {
        return $this->dagRunId;
    }

    /**
     * @return null
     */
    public function getUpstream()
    {
        return $this->upstream;
    }




}