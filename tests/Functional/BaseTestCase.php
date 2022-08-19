<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 19/08/22
 * Time: 08:50 م
 */

namespace Proxima\JobQueue\Tests\Functional;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class BaseTestCase extends WebTestCase
{

    static protected function createKernel(array $options = array()): KernelInterface
    {
        $config = isset($options['config']) ? $options['config'] : 'default.yaml';

        return new Kernel($config);
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
            $schemaTool->createSchema($metadata);
        }
    }
}