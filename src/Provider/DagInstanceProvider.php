<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 10:14 م
 */

namespace Proxima\JobQueue\Provider;
use Proxima\JobQueue\Manager\DagInstanceManager;
use Symfony\Component\Finder\Finder;

class DagInstanceProvider
{

    /**
     * @var DagInstanceManager
     */
    private $dagInstanceManager;
    /**
     * @var string
     */
    private $dagDir;
    /**
     * @var string
     */
    private $dagNamespace;

    /**
     * DagInstanceProvider constructor.
     * @param DagInstanceManager $dagInstanceManager
     * @param string $dagDir
     * @param string $dagNamespace
     */
    public function __construct(
        DagInstanceManager $dagInstanceManager,
        string $dagDir,
        string $dagNamespace)
    {
        $this->dagInstanceManager = $dagInstanceManager;
        $this->dagDir = $dagDir;
        $this->dagNamespace = $dagNamespace;
    }


    public function getCollection(): \Generator
    {
        $finder = new Finder();
        $finder->files()->in($this->dagDir)->name('*.php');
        foreach ($finder as $file) {
            $className = rtrim($this->dagNamespace, '\\') . '\\' . $file->getFilenameWithoutExtension();
            if (class_exists($className) && $this->dagInstanceManager->isDag($className)) {
                yield $this->dagInstanceManager->makeDagInstance($className);
            }
        }
    }




}