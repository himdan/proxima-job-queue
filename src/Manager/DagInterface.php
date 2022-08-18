<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 08:38 م
 */

namespace Proxima\JobQueue\Manager;


use Proxima\JobQueue\Dag;
use Proxima\JobQueue\Task;

interface DagInterface extends Dag
{
    /**
     * @param $taskId
     * @return Task[]
     */
    public function next($taskId);

    /**
     * @return Task[]
     */
    public function firstTasks();
}