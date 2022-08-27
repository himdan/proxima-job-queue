<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 22/08/22
 * Time: 08:16 م
 */

namespace Proxima\JobQueue\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Proxima\JobQueue\DTO\CreateDagDto;
use Proxima\JobQueue\Manager\DagInstanceManager;

class DagInstanceDataPersister implements DataPersisterInterface
{

    /**
     * @var DagInstanceManager $dagInstanceManager
     */
    private $dagInstanceManager;

    /**
     * DagInstanceDataPersister constructor.
     * @param DagInstanceManager $dagInstanceManager
     */
    public function __construct(DagInstanceManager $dagInstanceManager)
    {
        $this->dagInstanceManager = $dagInstanceManager;
    }


    public function supports($data): bool
    {
        return $data instanceof CreateDagDto;
    }

    /**
     * @param CreateDagDto $data
     * @return object
     */
    public function persist($data)
    {
        $dagInstance = $this->dagInstanceManager->makePersistentDagInstance($data->getDagId());
        $data->setId($dagInstance->getId());
        return $data;
    }

    /**
     * @param CreateDagDto $data
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }

}