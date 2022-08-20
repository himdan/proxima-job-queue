<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 12:47 م
 */

namespace Proxima\JobQueue\Attributes;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RunTime
{
    public $debug = false;
    public $maxTimeOut = -1;

    /**
     * RunTime constructor.
     * @param bool $debug
     * @param int $maxTimeOut
     */
    public function __construct(bool $debug=false, int $maxTimeOut=-1)
    {
        $this->debug = $debug;
        $this->maxTimeOut = $maxTimeOut;
    }


}