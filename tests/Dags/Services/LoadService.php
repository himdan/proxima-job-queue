<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 09:15 م
 */

namespace Proxima\JobQueue\Tests\Dags\Services;


class LoadService
{
    public  function  __invoke()
    {
        echo PHP_EOL;
        echo "LOADING";
        echo PHP_EOL;
    }
}