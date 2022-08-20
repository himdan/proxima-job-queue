<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 21/08/22
 * Time: 10:42 ص
 */

namespace Proxima\JobQueue\Tests\Functional;


use Proxima\JobQueue\Entity\DagInstance;
use Proxima\JobQueue\Provider\DagInstanceProvider;
use Proxima\JobQueue\Tests\Dags\Etl;
use Proxima\JobQueue\Tests\Dags\RetryEtl;
use Proxima\JobQueue\Tests\Dags\ScheduledEtl;

/**
 * Class DagInstanceProviderTest
 * @package Proxima\JobQueue\Tests\Functional
 */
class DagInstanceProviderTest extends BaseTestCase
{

    /**
     * @var DagInstanceProvider
     */
    private $dagInstanceProvider;

    protected function setUp(): void
    {
        $this->createClient();
        $this->importDatabaseSchema();
        $this->dagInstanceProvider = self::$kernel->getContainer()->get(DagInstanceProvider::class);
    }

    private function getAssertMap()
    {
        return [
            Etl::class => function (DagInstance $dagInstance) {
                $this->assertEquals('', $dagInstance->getScheduledFor());
                $this->assertFalse($dagInstance->isScheduledCatchup());
            },
            ScheduledEtl::class => function (DagInstance $dagInstance) {
                $this->assertEquals('@daily', $dagInstance->getScheduledFor());
                $this->assertTrue($dagInstance->isScheduledCatchup());

            },
            RetryEtl::class => function (DagInstance $dagInstance) {
                $this->assertEquals(3, $dagInstance->getRetryTimes());
                $this->assertTrue($dagInstance->isRetryOnFail());

            },
        ];
    }

    public function testGetCollection()
    {

        $assertMap = $this->getAssertMap();
        $nbr = 0;

        /**
         * @var DagInstance $item
         */
        foreach ($this->dagInstanceProvider->getCollection() as $item) {
            $this->assertInstanceOf(DagInstance::class, $item);
            if (!in_array($item->getDagId(), array_keys($assertMap))) {
                continue;
            }
            $nbr++;
            $assertMap[$item->getDagId()]($item);
        }

        $this->assertGreaterThanOrEqual(3, $nbr);
    }
}