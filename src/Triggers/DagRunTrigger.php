<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 11:54 م
 */

namespace Proxima\JobQueue\Triggers;


class DagRunTrigger
{
    private $dagRunId;

    /**
     * DagRunTrigger constructor.
     * @param $dagRunId
     */
    public function __construct($dagRunId)
    {
        $this->dagRunId = $dagRunId;
    }

    /**
     * @return mixed
     */
    public function getDagRunId()
    {
        return $this->dagRunId;
    }




}