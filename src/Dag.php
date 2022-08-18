<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 07:15 م
 */

namespace Proxima\JobQueue;


interface Dag
{
    /**
     * @return mixed
     */
    public function getDagId();

    /**
     * @return Task[]
     */
    public function getTasks(): array ;
}