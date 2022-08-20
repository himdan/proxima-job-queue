<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 12:42 م
 */

namespace Proxima\JobQueue\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Retry
{
    public $onFail = false;
    public $times = 0;
    public $preRetryCallback = null;

    /**
     * Retry constructor.
     * @param bool $onFail
     * @param int $times
     * @param null $preRetryCallback
     */
    public function __construct(bool $onFail = false, int $times = 0, $preRetryCallback = null)
    {
        $this->onFail = $onFail;
        $this->times = $times;
        $this->preRetryCallback = $preRetryCallback;
    }

}