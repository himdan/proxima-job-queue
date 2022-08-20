<?php
/**
 * Created by PhpStorm.
 * User: chehimi
 * Date: 20/08/22
 * Time: 11:06 م
 */

namespace Proxima\JobQueue\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class DagInstance
{

    use IdentityTrait;

    /**
     * @var string
     */
    #[ORM\Column(type:'string')]
    private $scheduledFor = "";
    /**
     * @var bool
     */
    #[ORM\Column(type:'boolean')]
    private $scheduledCatchup = false;
    /**
     * @var bool
     */
    #[ORM\Column(type:'boolean')]
    private $retryOnFail = false;
    /**
     * @var int
     */
    #[ORM\Column(type:'integer')]
    private $retryTimes = -1;
    /**
     * @var ?string
     */
    #[ORM\Column(type:'string', nullable:true)]
    private $retryPreRetryCallback;
    /**
     * @var bool
     */
    #[ORM\Column(type:'boolean')]
    private $runtimeDebug=false;
    /**
     * @var int
     */
    #[ORM\Column(type:'integer')]
    private $runtimeMaxTimeout=-1;

    /**
     * @var string
     */
    #[ORM\Column(type:'string')]
    private $dagId;

    /**
     * DagInstance constructor.
     * @param string $dagId
     */
    public function __construct(string $dagId)
    {
        $this->dagId = $dagId;
    }


    /**
     * @return string
     */
    public function getScheduledFor(): string
    {
        return $this->scheduledFor;
    }

    /**
     * @param string $scheduledFor
     * @return DagInstance
     */
    public function setScheduledFor(string $scheduledFor): DagInstance
    {
        $this->scheduledFor = $scheduledFor;
        return $this;
    }

    /**
     * @return bool
     */
    public function isScheduledCatchup(): bool
    {
        return $this->scheduledCatchup;
    }

    /**
     * @param bool $scheduledCatchup
     * @return DagInstance
     */
    public function setScheduledCatchup(bool $scheduledCatchup): DagInstance
    {
        $this->scheduledCatchup = $scheduledCatchup;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRetryOnFail(): bool
    {
        return $this->retryOnFail;
    }

    /**
     * @param bool $retryOnFail
     * @return DagInstance
     */
    public function setRetryOnFail(bool $retryOnFail): DagInstance
    {
        $this->retryOnFail = $retryOnFail;
        return $this;
    }

    /**
     * @return int
     */
    public function getRetryTimes(): int
    {
        return $this->retryTimes;
    }

    /**
     * @param int $retryTimes
     * @return DagInstance
     */
    public function setRetryTimes(int $retryTimes): DagInstance
    {
        $this->retryTimes = $retryTimes;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getRetryPreRetryCallback(): ?string
    {
        return $this->retryPreRetryCallback;
    }

    /**
     * @param ?string $retryPreRetryCallback
     * @return DagInstance
     */
    public function setRetryPreRetryCallback(?string $retryPreRetryCallback): DagInstance
    {
        $this->retryPreRetryCallback = $retryPreRetryCallback;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRuntimeDebug(): bool
    {
        return $this->runtimeDebug;
    }

    /**
     * @param bool $runtimeDebug
     * @return DagInstance
     */
    public function setRuntimeDebug(bool $runtimeDebug): DagInstance
    {
        $this->runtimeDebug = $runtimeDebug;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRuntimeMaxTimeout(): bool
    {
        return $this->runtimeMaxTimeout;
    }

    /**
     * @param bool $runtimeMaxTimeout
     * @return DagInstance
     */
    public function setRuntimeMaxTimeout(bool $runtimeMaxTimeout): DagInstance
    {
        $this->runtimeMaxTimeout = $runtimeMaxTimeout;
        return $this;
    }

    /**
     * @return string
     */
    public function getDagId(): string
    {
        return $this->dagId;
    }







}