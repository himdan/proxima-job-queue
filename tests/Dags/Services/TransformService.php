<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 09:14 م
 */

namespace Proxima\JobQueue\Tests\Dags\Services;


class TransformService
{
    public  function __invoke()
    {
        echo PHP_EOL;
        echo "TRANSFORMING";
        echo PHP_EOL;
    }
}