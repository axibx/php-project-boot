<?php

namespace WeimobCloudBoot\Com\Weimob\Cloud\Spi\Xinyun;

use WeimobCloudBoot\Com\Weimob\Cloud\Spi\PaasResponseCode;

interface XinyunPaasWeimobShopCouponPaasBatchLockCouponService
{
    public function excute(XinyunPaasWeimobShopCouponPaasBatchLockCouponRequest $request):XinyunPaasWeimobShopCouponPaasBatchLockCouponResponse;
}

class XinyunPaasWeimobShopCouponPaasBatchLockCouponRequest implements \JsonSerializable
{
    /**
     * @return string
     */
    public function getSign(): string
    {
        return $this->sign;
    }

    /**
     * @param string $sign
     */
    public function setSign(string $sign): void
    {
        $this->sign = $sign;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getParams(): string
    {
        return $this->params;
    }

    /**
     * @param string $params
     */
    public function setParams(string $params): void
    {
        $this->params = $params;
    }

    /**
     * @return int
     */
    public function getPid(): int
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     */
    public function setPid(int $pid): void
    {
        $this->pid = $pid;
    }

    /**
     * @return int
     */
    public function getBosId(): int
    {
        return $this->bosId;
    }

    /**
     * @param int $bosId
     */
    public function setBosId(int $bosId): void
    {
        $this->bosId = $bosId;
    }

    /**
     * @return string
     */
    public function getActionKey(): string
    {
        return $this->actionKey;
    }

    /**
     * @param string $actionKey
     */
    public function setActionKey(string $actionKey): void
    {
        $this->actionKey = $actionKey;
    }

    /**
     * @return int
     */
    public function getVid(): int
    {
        return $this->vid;
    }

    /**
     * @param int $vid
     */
    public function setVid(int $vid): void
    {
        $this->vid = $vid;
    }

    /**
     * @return int
     */
    public function getVType(): int
    {
        return $this->vType;
    }

    /**
     * @param int $vType
     */
    public function setVType(int $vType): void
    {
        $this->vType = $vType;
    }

    /**
     * @return int
     */
    public function getOriginProductId(): int
    {
        return $this->originProductId;
    }

    /**
     * @param int $originProductId
     */
    public function setOriginProductId(int $originProductId): void
    {
        $this->originProductId = $originProductId;
    }

    /**
     * @return int
     */
    public function getTargetProductId(): int
    {
        return $this->targetProductId;
    }

    /**
     * @param int $targetProductId
     */
    public function setTargetProductId(int $targetProductId): void
    {
        $this->targetProductId = $targetProductId;
    }

    /**
     * @return int
     */
    public function getOriginProductInstanceId(): int
    {
        return $this->originProductInstanceId;
    }

    /**
     * @param int $originProductInstanceId
     */
    public function setOriginProductInstanceId(int $originProductInstanceId): void
    {
        $this->originProductInstanceId = $originProductInstanceId;
    }

    /**
     * @return int
     */
    public function getTargetProductInstanceId(): int
    {
        return $this->targetProductInstanceId;
    }

    /**
     * @param int $targetProductInstanceId
     */
    public function setTargetProductInstanceId(int $targetProductInstanceId): void
    {
        $this->targetProductInstanceId = $targetProductInstanceId;
    }

    /**
     * @return int
     */
    public function getFunctionId(): int
    {
        return $this->functionId;
    }

    /**
     * @param int $functionId
     */
    public function setFunctionId(int $functionId): void
    {
        $this->functionId = $functionId;
    }
    /**
     * @var string
     */
    private $sign;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var string
     */
    private $params;

    /**
     * @var int
     */
    private $pid;

    /**
     * @var int
     */
    private $bosId;

    /**
     * @var string
     */
    private $actionKey;

    /**
     * @var int
     */
    private $vid;

    /**
     * @var int
     */
    private $vType;

    /**
     * @var int
     */
    private $originProductId;

    /**
     * @var int
     */
    private $targetProductId;

    /**
     * @var int
     */
    private $originProductInstanceId;

    /**
     * @var int
     */
    private $targetProductInstanceId;

    /**
     * @var int
     */
    private $functionId;


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class PaasWeimobShopCouponPaasBatchLockCouponParam implements \JsonSerializable
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $age;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class XinyunPaasWeimobShopCouponPaasBatchLockCouponResponse implements \JsonSerializable
{
    /**
     * @return PaasResponseCode
     */
    public function getCode(): PaasResponseCode
    {
        return $this->paasResponseCode;
    }

    /**
     * @param PaasResponseCode $paasResponseCode
     */
    public function setCode(PaasResponseCode $paasResponseCode): void
    {
        $this->paasResponseCode = $paasResponseCode;
    }

    /**
     * @return bool
     */
    public function getData(): bool
    {
        return $this->data;
    }

    /**
     * @param bool $data
     */
    public function setData(bool $data): void
    {
        $this->data = $data;
    }
    /** @var PaasResponseCode */
    private $code;

    /** @var bool */
    private $data;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

