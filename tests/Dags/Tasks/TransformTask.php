<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 09:17 م
 */

namespace Proxima\JobQueue\Tests\Dags\Tasks;


use Proxima\JobQueue\Task;
use Proxima\JobQueue\Tests\Dags\Services\TransformService;

class TransformTask implements Task
{
    public function getTaskId(): string
    {
        return 'transform';
    }

    public function getServiceId(): string
    {
        return TransformService::class;
    }
}