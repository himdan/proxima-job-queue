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
use Traversable;

class DagInstanceProvider implements \Countable, \IteratorAggregate
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
     * @var callable|null
     */
    private $preFilterCb;

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

    /**
     * @param callable|null $preFilterCb
     * @return DagInstanceProvider
     */
    public function setPreFilterCb(?callable $preFilterCb): DagInstanceProvider
    {
        $this->preFilterCb = $preFilterCb;
        return $this;
    }


    public function getCollection(): \Generator
    {
        $finder = new Finder();
        $finder->files()->in($this->dagDir)->name('*.php');
        foreach ($finder as $file) {
            $className = rtrim($this->dagNamespace, '\\') . '\\' . $file->getFilenameWithoutExtension();
            if (class_exists($className) && $this->dagInstanceManager->isDag($className)) {
                $instance = $this->dagInstanceManager->makeDagInstance($className);
                if(!is_callable($this->preFilterCb)){
                    yield $instance;
                    continue;
                }
                if(call_user_func($this->preFilterCb, $instance)){
                    yield $instance;
                }
            }
        }
    }

    public function getIterator()
    {
        return $this->getCollection();
    }

    public function count()
    {
        return count(iterator_to_array($this->getCollection()));
    }


}