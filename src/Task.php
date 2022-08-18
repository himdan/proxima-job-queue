<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 07:16 م
 */

namespace Proxima\JobQueue;


interface Task
{
    public function getTaskId():string;
    public function getServiceId():string;
}