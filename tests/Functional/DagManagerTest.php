<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 09:45 م
 */

namespace Proxima\JobQueue\Tests\Functional;


use Proxima\JobQueue\Entity\DagInstance;
use Proxima\JobQueue\Entity\DagRun;
use Proxima\JobQueue\Entity\TaskRun;
use Proxima\JobQueue\Events\DagRunCreatedEvent;
use Proxima\JobQueue\Events\RunDagRunEvent;
use Proxima\JobQueue\Manager\DagManager;
use Proxima\JobQueue\Manager\TaskManager;
use Proxima\JobQueue\Tests\Dags\Etl;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class DagManagerTest extends BaseTestCase
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var int
     */
    private $dagRunCreatedEventTimes = 0;

    /**
     * @var int
     */
    private $runDagRunEventTimes = 0;
    /**
     * @var Etl
     */
    private $etl;
    /**
     * @var DagManager
     */
    private $dagManager;

    protected function setUp(): void
    {
        $this->createClient();
        $this->importDatabaseSchema();
        /**
         * @var Etl $etl
         */
        $this->etl = self::$kernel->getContainer()->get(Etl::class);
        /**
         * @var DagManager $dagManager
         */
        $this->dagManager = self::$kernel->getContainer()->get(DagManager::class);
        $this->eventDispatcher = self::$kernel->getContainer()->get('event_dispatcher');
        $this->eventDispatcher->addListener(DagRunCreatedEvent::class, function (DagRunCreatedEvent $event) {
            $this->dagRunCreatedEventTimes++;
        });
        $this->eventDispatcher->addListener(RunDagRunEvent::class, function (RunDagRunEvent $event) {
            $this->runDagRunEventTimes++;
        });
    }

    public function testRegister()
    {


        $dagRun = $this->dagManager->createDagInstance($this->etl);


        $this->assertGreaterThan(0, $this->dagRunCreatedEventTimes);


        $this->assertNotNull($dagRun->getId());
        $this->assertInstanceOf(DagInstance::class , $dagRun->getDagInstance());

        $this->assertCount(
            3,
            $dagRun->getTasks()
        );

        foreach ($dagRun->getTaskRuns() as $task) {
            $this->assertNotNull($task->getId());
            $this->assertNotNull($task->getTaskId());
        }

        return $dagRun;


    }

    /**
     * @depends testRegister
     * @param DagRun $dagRun
     * @return DagRun
     */
    public function testRun(DagRun $dagRun)
    {

        $this->dagManager->run($dagRun);
        $this->assertGreaterThan(0, $this->runDagRunEventTimes);
        $this->assertNotNull($dagRun->getId());

        foreach ($dagRun->getTaskRuns()->filter(function (TaskRun $taskRun) {
            return $taskRun->getTaskId() === 'extract';
        }) as $taskRun) {
            $this->assertEquals(TaskManager::Queued, $taskRun->getState());
        }

        foreach ($dagRun->getTaskRuns()->filter(function (TaskRun $taskRun) {
            return in_array($taskRun->getTaskId(), ['load', 'transform']);
        }) as $taskRun) {
            $this->assertNull($taskRun->getState());
        }


        return $dagRun;
    }

    /**
     * @depends  testRun
     */
    public function testNextExtract(DagRun $dagRun)
    {
        /**
         * @var TaskRun $taskRun
         */
        $taskRun = $dagRun->getTaskRuns()->filter(function (TaskRun $taskRun) {
            return $taskRun->getTaskId() === 'extract';
        })->first();
        $taskRun->setState(TaskManager::STATE_SUCCESS);

        $this->dagManager->next($taskRun);

        $this->assertGreaterThan(0, $this->runDagRunEventTimes);

        foreach ($dagRun->getTaskRuns()->filter(function (TaskRun $taskRun) {
            return in_array($taskRun->getTaskId(), ['transform']);
        }) as $taskRun) {
            $this->assertEquals(TaskManager::Queued, $taskRun->getState());
        }

        return $dagRun;

    }

    /**
     * @depends  testNextExtract
     */
    public function testNextTransform(DagRun $dagRun)
    {
        /**
         * @var TaskRun $taskRun
         */
        $taskRun = $dagRun->getTaskRuns()->filter(function (TaskRun $taskRun) {
            return $taskRun->getTaskId() === 'transform';
        })->first();
        $taskRun->setState(TaskManager::STATE_SUCCESS);

        $this->dagManager->next($taskRun);
        $this->assertGreaterThan(0, $this->runDagRunEventTimes);

        foreach ($dagRun->getTaskRuns()->filter(function (TaskRun $taskRun) {
            return in_array($taskRun->getTaskId(), ['load']);
        }) as $taskRun) {
            $this->assertEquals(TaskManager::Queued, $taskRun->getState());
        }

        return $dagRun;

    }

    /**
     * @depends  testNextTransform
     */
    public function testNextLoad(DagRun $dagRun)
    {
        /**
         * @var TaskRun $taskRun
         */
        $taskRun = $dagRun->getTaskRuns()->filter(function (TaskRun $taskRun) {
            return $taskRun->getTaskId() === 'load';
        })->first();
        $taskRun->setState(TaskManager::STATE_SUCCESS);

        $this->dagManager->next($taskRun);
        $this->assertGreaterThan(0, $this->runDagRunEventTimes);

        foreach ($dagRun->getTaskRuns() as $taskRun) {
            $this->assertNotNull(TaskManager::STATE_SUCCESS, $taskRun->getState());
        }

    }
}