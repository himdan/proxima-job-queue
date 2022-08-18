<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 09:56 م
 */

namespace Proxima\JobQueue\Message;


class TaskSuccessMessage extends TaskStateMessage
{
    private $upstream;

    public function __construct($taskRunId, $upstream = null)
    {
        parent::__construct($taskRunId);
        $this->upstream = $upstream;
    }

    /**
     * @return null
     */
    public function getUpstream()
    {
        return $this->upstream;
    }




}