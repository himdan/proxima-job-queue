<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 09:00 م
 */

namespace Proxima\JobQueue\Tests\Dags\Tasks;


use Proxima\JobQueue\Task;
use Proxima\JobQueue\Tests\Dags\Services\ExtractService;

class ExtractTask implements Task
{
    public function getTaskId(): string
    {
        return 'extract';
    }

    public function getServiceId(): string
    {
        return ExtractService::class;
    }

}