<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 16/08/22
 * Time: 06:56 م
 */

namespace Proxima\JobQueue\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;

trait IdentityTrait
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:'AUTO')]
    #[ORM\Column(type:"integer")]
    #[ApiProperty(identifier:true)]
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}