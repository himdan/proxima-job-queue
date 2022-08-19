<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 09:19 م
 */

namespace Proxima\JobQueue\Tests\Dags\Tasks;


use Proxima\JobQueue\Task;
use Proxima\JobQueue\Tests\Dags\Services\LoadService;

class LoadTask implements Task
{
    public function getTaskId(): string
    {
        return 'load';
    }

    public function getServiceId(): string
    {
       return LoadService::class;
    }

}