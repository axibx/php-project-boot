<?php

namespace WeimobCloudBoot\Com\Weimob\Cloud\Spi;

interface PaasWeimobShopCouponPaasBatchLockCouponService
{
    const specType = 'wos';

    const requestClass = WeimobShopCouponPaasBatchLockCouponRequest::class;
    const responseClass = WeimobShopCouponPaasBatchLockCouponResponse::class;

    public function invoke(WeimobShopCouponPaasBatchLockCouponRequest $request) : WeimobShopCouponPaasBatchLockCouponResponse;
}

class WeimobShopCouponPaasBatchLockCouponRequest
{
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
     * @return String
     */
    public function getActionKey(): string
    {
        return $this->actionKey;
    }

    /**
     * @param String $actionKey
     */
    public function setActionKey(string $actionKey): void
    {
        $this->actionKey = $actionKey;
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
     * @return WeimobShopCouponPaasBatchLockCouponParam
     */
    public function getParams(): WeimobShopCouponPaasBatchLockCouponParam
    {
        return $this->params;
    }

    /**
     * @param WeimobShopCouponPaasBatchLockCouponParam $params
     */
    public function setParams(WeimobShopCouponPaasBatchLockCouponParam $params): void
    {
        $this->params = $params;
    }
    /**
     * 商业操作系统ID
     * @var int
     */
    private $bosId;

    /**
     * 全局唯一的扩展点
     * @var string
     */
    private $actionKey;

    /**
     * 功能集ID
     * @var int
     */
    private $functionId;

    /**
     * 组织结构节点ID
     * @var int
     */
    private $vid;

    /**
     * 	组织结构节点类型
     * @var int
     */
    private $vType;

    /**
     * @var WeimobShopCouponPaasBatchLockCouponParam
     */
    private $params;
}
class WeimobShopCouponPaasBatchLockCouponParam
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
     * @return string
     */
    public function getAge(): string
    {
        return $this->age;
    }

    /**
     * @param string $age
     */
    public function setAge(string $age): void
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

}

class WeimobShopCouponPaasBatchLockCouponResponse implements \JsonSerializable
{
    /**
     * @return WeimobShopCouponPaasBatchLockCouponData
     */
    public function getData(): WeimobShopCouponPaasBatchLockCouponData
    {
        return $this->data;
    }

    /**
     * @param WeimobShopCouponPaasBatchLockCouponData $data
     */
    public function setData(WeimobShopCouponPaasBatchLockCouponData $data): void
    {
        $this->data = $data;
    }

    /**
     * @return PaasResponseCode
     */
    public function getCode(): PaasResponseCode
    {
        return $this->code;
    }

    /**
     * @param PaasResponseCode $code
     */
    public function setCode(PaasResponseCode $code): void
    {
        $this->code = $code;
    }
    /**
     * 请求返回的数据
     * @var WeimobShopCouponPaasBatchLockCouponData
     */
    private $data;

    /**
     * 请求返回的对象
     * @var PaasResponseCode
     */
    private $code;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
class WeimobShopCouponPaasBatchLockCouponData implements \JsonSerializable
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
     * @return string
     */
    public function getAge(): string
    {
        return $this->age;
    }

    /**
     * @param string $age
     */
    public function setAge(string $age): void
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