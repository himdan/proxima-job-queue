<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 22/08/22
 * Time: 08:36 م
 */

namespace Proxima\JobQueue\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Proxima\JobQueue\Entity\DagInstance;
use Proxima\JobQueue\Provider\DagInstanceProvider;

class DagInstanceDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var DagInstanceProvider $dagInstanceProvider
     */
    private $dagInstanceProvider;

    /**
     * DagInstanceDataProvider constructor.
     * @param DagInstanceProvider $dagInstanceProvider
     */
    public function __construct(DagInstanceProvider $dagInstanceProvider)
    {
        $this->dagInstanceProvider = $dagInstanceProvider;
    }


    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $filters = [];
        $this->dagInstanceProvider->setPreFilterCb(function (DagInstance $dagInstance) use ($filters) {
            return true;
        });
        $i = 0;
        /**
         * @var DagInstance $item
         */
        foreach ($this->dagInstanceProvider->getCollection() as $item){
            $i++;
            if(null === $item->getId()){
                $item->setId($i);
            }
            yield $item;
        }

    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return 'get' === $operationName && DagInstance::class === $resourceClass;
    }

}