<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 08:59 م
 */

namespace Proxima\JobQueue\Tests\Dags;


use Proxima\JobQueue\Manager\DagInterface;
use Proxima\JobQueue\Tests\Dags\Tasks\ExtractTask;
use Proxima\JobQueue\Tests\Dags\Tasks\LoadTask;
use Proxima\JobQueue\Tests\Dags\Tasks\TransformTask;

class Etl implements DagInterface
{

    /**
     * @var ExtractTask
     */
    private $extractTask;
    /**
     * @var TransformTask
     */
    private $transformTask;
    /**
     * @var LoadTask
     */
    private $loadTask;

    /**
     * Etl constructor.
     * @param ExtractTask $extractTask
     * @param TransformTask $transformTask
     * @param LoadTask $loadTask
     */
    public function __construct(
        ExtractTask $extractTask,
        TransformTask $transformTask,
        LoadTask $loadTask)
    {
        $this->extractTask = $extractTask;
        $this->transformTask = $transformTask;
        $this->loadTask = $loadTask;
    }


    public function getDagId()
    {
        return self::class;
    }

    public function getTasks(): array
    {
        return [
            $this->extractTask,
            $this->transformTask,
            $this->loadTask
        ];
    }

    public function next($taskId)
    {
        $runTimeMap = [
            "extract" => [$this->transformTask],
            "transform" => [$this->loadTask]
        ];
        if (array_key_exists($taskId, $runTimeMap)) {
            return $runTimeMap[$taskId];
        }
        return [];
    }

    public function firstTasks()
    {
        return [
            $this->extractTask
        ];
    }

}