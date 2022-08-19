<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 09:06 م
 */

namespace Proxima\JobQueue\Tests\Dags\Services;


class ExtractService
{
    public function __invoke()
    {

        echo PHP_EOL;
        echo "EXTRACTING";
        echo PHP_EOL;
    }
}