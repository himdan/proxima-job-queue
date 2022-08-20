<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 10:23 ص
 */

namespace Proxima\JobQueue\Tests\Functional;


use Proxima\JobQueue\Entity\DagRun;
use Proxima\JobQueue\Entity\TaskRun;
use Proxima\JobQueue\Manager\DagInterface;
use Proxima\JobQueue\Manager\DagManager;
use Proxima\JobQueue\Manager\TaskManager;
use Proxima\JobQueue\Tests\Dags\Etl;
use Proxima\JobQueue\Triggers\DagRunTrigger;
use Symfony\Component\Messenger\MessageBusInterface;

class RunnerTest extends BaseTestCase
{
    /**
     * @var MessageBusInterface $messageBus
     */
    private $messageBus;
    /**
     * @var DagRun
     */
    private $dagRun;

    protected function setUp(): void
    {
        $this->createClient();
        $this->importDatabaseSchema();
        $this->messageBus = self::$kernel->getContainer()->get("test.message_bus");
        /**
         * @var DagInterface $etl
         */
        $etl = self::$kernel->getContainer()->get(Etl::class);
        /**
         * @var DagManager $dagManager
         */
        $dagManager = self::$kernel->getContainer()->get(DagManager::class);

        $this->dagRun = $dagManager->createDagInstance($etl);

    }

    public function testDispatchDagRun()
    {
        $dagRunTrigger = new DagRunTrigger($this->dagRun->getId());
        $this->messageBus->dispatch($dagRunTrigger);
        $this->assertEquals($this->dagRun->getState(), TaskManager::Queued);

        $this->assertCount(
            3,
            $this->dagRun->getTasks()
        );

        $this->assertCount(
            0,
            $this->dagRun->getTaskRuns()->filter(function(TaskRun $taskRun){
                return $taskRun->getState() === TaskManager::Queued;
            })->toArray()
        );
    }
}