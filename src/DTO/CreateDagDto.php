<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 21/08/22
 * Time: 08:03 م
 */

namespace Proxima\JobQueue\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;


#[ApiResource(collectionOperations:["post"], itemOperations: ["get"])]
class CreateDagDto
{

    #[ApiProperty(identifier:true)]
    private $id;
    /**
     * @var string
     */
    private $dagId;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDagId(): string
    {
        return $this->dagId;
    }

    /**
     * @param string $dagId
     */
    public function setDagId(string $dagId): void
    {
        $this->dagId = $dagId;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }






}