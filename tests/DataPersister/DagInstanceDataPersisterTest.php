<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 27/08/22
 * Time: 09:08 ص
 */

namespace Proxima\JobQueue\Tests\DataPersister;


use PHPUnit\Framework\TestCase;
use Proxima\JobQueue\DataPersister\DagInstanceDataPersister;
use Proxima\JobQueue\DTO\CreateDagDto;
use Proxima\JobQueue\Entity\DagInstance;
use Proxima\JobQueue\Manager\DagInstanceManager;
use Proxima\JobQueue\Tests\Dags\Etl;

class DagInstanceDataPersisterTest extends TestCase
{

    private function getDagInstanceManager()
    {
        $mb = $this
            ->getMockBuilder(DagInstanceManager::class);
        $mb->disableOriginalConstructor();
        $dagInstanceManager = $mb->getMock();
        $dagInstanceManager
            ->method('makePersistentDagInstance')
            ->with(Etl::class)
            ->willReturn(new DagInstance(Etl::class))
        ;
        return $dagInstanceManager;
    }

    private function getCreateDagDto()
    {
        $dagDto = new CreateDagDto();
        $dagDto->setDagId(Etl::class);
        return $dagDto;
    }

    public function testConstruct()
    {

        $dagInstanceDataPersister = new DagInstanceDataPersister($this->getDagInstanceManager());
        $this->assertInstanceOf(DagInstanceDataPersister::class, $dagInstanceDataPersister);
        return $dagInstanceDataPersister;
    }

    /**
     * @depends testConstruct
     * @param DagInstanceDataPersister $dagInstanceDataPersister
     * @return DagInstanceDataPersister
     */
    public function testSupportWillReturnTrue(DagInstanceDataPersister $dagInstanceDataPersister)
    {
        $support = $dagInstanceDataPersister->supports($this->getCreateDagDto());
        $this->assertTrue($support);
        return $dagInstanceDataPersister;
    }

    /**
     * @depends testSupportWillReturnTrue
     * @param DagInstanceDataPersister $dagInstanceDataPersister
     */
    public function testPersist(DagInstanceDataPersister $dagInstanceDataPersister)
    {
        $dagInstance = $dagInstanceDataPersister->persist($this->getCreateDagDto());
        $this->assertInstanceOf(CreateDagDto::class, $dagInstance);
    }
}