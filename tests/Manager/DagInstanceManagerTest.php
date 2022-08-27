<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 27/08/22
 * Time: 10:14 ص
 */

namespace Proxima\JobQueue\Tests\Manager;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use Proxima\JobQueue\Entity\DagInstance;
use Proxima\JobQueue\Manager\DagInstanceManager;
use Proxima\JobQueue\Tests\Dags\Etl;

class DagInstanceManagerTest extends TestCase
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;
    /**
     * @var EntityRepository
     */
    private $repository;

    protected function setUp(): void
    {

        $this->repository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManagerMb = $this->getMockBuilder(EntityManagerInterface::class);
        $this->em = $entityManagerMb->getMock();
        $this
            ->em
            ->method('getRepository')
            ->with(DagInstance::class)
            ->willReturn($this->repository);


    }

    /**
     * @return DagInstanceManager
     */
    public function testConstruct()
    {
        $dagInstanceManager = new DagInstanceManager($this->em);
        $this->assertInstanceOf(DagInstanceManager::class, $dagInstanceManager);
        return $dagInstanceManager;
    }

    /**
     * @depends testConstruct
     * @param DagInstanceManager $dagInstanceManager
     */
    public function testIsDag(DagInstanceManager $dagInstanceManager)
    {
        $test = $dagInstanceManager->isDag(Etl::class);
        $this->assertTrue($test);
    }

    /**
     * @depends testConstruct
     * @param DagInstanceManager $dagInstanceManager
     */
    public function testMakeDagInstance(DagInstanceManager $dagInstanceManager)
    {
        $dagInstance = $dagInstanceManager->makeDagInstance(Etl::class);
        $this->assertInstanceOf(DagInstance::class, $dagInstance);
    }

    /**
     * @depends testConstruct
     * @param DagInstanceManager $dagInstanceManager
     */
    public function testMakePersistentDagInstance(DagInstanceManager $dagInstanceManager)
    {
        $dagInstance = $dagInstanceManager->makePersistentDagInstance(Etl::class);
        $this->assertInstanceOf(DagInstance::class, $dagInstance);
    }
}