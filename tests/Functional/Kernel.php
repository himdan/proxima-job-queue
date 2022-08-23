<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 18/08/22
 * Time: 09:48 م
 */

namespace Proxima\JobQueue\Tests\Functional;
use ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle;
use DAMA\DoctrineTestBundle\DAMADoctrineTestBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle;
use Hautelook\AliceBundle\HautelookAliceBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{

    private $config;

    public function __construct($config)
    {
        parent::__construct('test', false);

        $fs = new Filesystem();
        if (!$fs->isAbsolutePath($config)) {
            $config = __DIR__.'/config/'.$config;
        }

        if ( ! is_file($config)) {
            throw new \RuntimeException(sprintf('The config file "%s" does not exist.', $config));
        }

        $this->config = $config;
    }

    public function registerBundles():iterable
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new ApiPlatformBundle(),
            new MakerBundle(),
            new DAMADoctrineTestBundle()
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->config);
    }

    public function getCacheDir():string
    {
        return sys_get_temp_dir().'/'.Kernel::VERSION.'/ProximaJobQueue/'.substr(sha1($this->config), 0, 6).'/cache';
    }

    public static function getCacheLocation(){
        return sys_get_temp_dir().'/'.Kernel::VERSION.'/ProximaJobQueue';
    }

    public function getContainerClass(): string
    {
        return parent::getContainerClass().'_'.substr(sha1($this->config), 0, 6);
    }

    public function getLogDir():string
    {
        return sys_get_temp_dir().'/'.Kernel::VERSION.'/ProximaJobQueue/'.substr(sha1($this->config), 0, 6).'/logs';
    }

    public function serialize()
    {
        return $this->config;
    }

    public function unserialize($config)
    {
        $this->__construct($config);
    }


}