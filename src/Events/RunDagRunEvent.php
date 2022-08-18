<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 11:13 م
 */

namespace Proxima\JobQueue\Events;


use Symfony\Component\Workflow\Event\Event;

class RunDagRunEvent extends Event
{
    private $dagRunId;
    private $upstream;

    /**
     * RunDagRunEvent constructor.
     * @param $dagRunId
     * @param $upstream
     */
    public function __construct($dagRunId, $upstream)
    {
        $this->dagRunId = $dagRunId;
        $this->upstream = $upstream;
    }


}