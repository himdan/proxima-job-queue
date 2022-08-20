<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 12:40 م
 */

namespace Proxima\JobQueue\Attributes;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Scheduled
{
    public $for = "";
    public $catchup = false;

    /**
     * Scheduled constructor.
     * @param string $for
     * @param bool $catchup
     */
    public function __construct(string $for="", bool $catchup=false)
    {
        $this->for = $for;
        $this->catchup = $catchup;
    }

}