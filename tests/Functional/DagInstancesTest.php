<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 22/08/22
 * Time: 09:18 م
 */

namespace Proxima\JobQueue\Tests\Functional;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManagerInterface;

class DagInstancesTest extends ApiTestCase
{
    static protected function createKernel(array $options = array()): KernelInterface
    {
        $config = isset($options['config']) ? $options['config'] : 'default.yaml';

        return new Kernel($config);
    }

    protected function setUp(): void
    {
        $this->createClient();
        $this->importDatabaseSchema();

    }

    protected final function importDatabaseSchema()
    {
        foreach (self::$kernel->getContainer()->get('doctrine')->getManagers() as $em) {
            $this->importSchemaForEm($em);
        }
    }

    private function importSchemaForEm(EntityManagerInterface $em)
    {
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
            try{

                $schemaTool->createSchema($metadata);
            } catch (\Exception $exception){

            }
        }
    }

    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response =  static::createClient()->request('GET', '/dag_instances');
        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertCount(3, $response->toArray()['hydra:member']);

    }
}