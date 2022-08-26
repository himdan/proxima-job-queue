<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 17/08/22
 * Time: 11:43 م
 */

namespace Proxima\JobQueue\Runner;
use Proxima\JobQueue\Manager\DagManager;
use Proxima\JobQueue\Triggers\DagRunTrigger;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class DagRunHandler
 * @package Proxima\JobQueue\Runner
 */
class DagRunHandler implements MessageHandlerInterface
{

    /**
     * @var DagManager
     */
    private $dagManager;

    /**
     * DagRunHandler constructor.
     * @param DagManager $dagManager
     */
    public function __construct(DagManager $dagManager)
    {
        $this->dagManager = $dagManager;
    }


    public function __invoke(DagRunTrigger $dagRunTrigger)
    {
        $dagRun = $this->dagManager->findDagRunById($dagRunTrigger->getDagRunId());

        if(!$this->dagManager->isRunnable($dagRun)){
            return;
        }
        $this->dagManager->run($dagRun);


    }
}