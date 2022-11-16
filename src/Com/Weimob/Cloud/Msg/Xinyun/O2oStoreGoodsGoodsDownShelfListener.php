<?php

namespace WeimobCloudBoot\Com\Weimob\Cloud\Msg\Xinyun;

use WeimobCloudBoot\Com\Weimob\Cloud\Msg\WeimobMessageAck;

interface O2oStoreGoodsGoodsDownShelfListener
{
    const classType = GoodsDownShelfMessage::class;
    public function onMessage(WeimobXinyunMessage $message):WeimobMessageAck;
}

class WeimobXinyunMessage implements \JsonSerializable
{
    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTopic(): ?string
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic(?string $topic): void
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(?string $event): void
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getBusinessId(): ?string
    {
        return $this->business_id;
    }

    /**
     * @param string $business_id
     */
    public function setBusinessId(?string $business_id): void
    {
        $this->business_id = $business_id;
    }

    /**
     * @return string
     */
    public function getPublicAccountId(): ?string
    {
        return $this->public_account_id;
    }

    /**
     * @param string $public_account_id
     */
    public function setPublicAccountId(?string $public_account_id): void
    {
        $this->public_account_id = $public_account_id;
    }

    /**
     * @return string
     */
    public function getSign(): ?string
    {
        return $this->sign;
    }

    /**
     * @param string $sign
     */
    public function setSign(?string $sign): void
    {
        $this->sign = $sign;
    }

    /**
     * @return string
     */
    public function getMsgSignature(): ?string
    {
        return $this->msgSignature;
    }

    /**
     * @param string $msgSignature
     */
    public function setMsgSignature(?string $msgSignature): void
    {
        $this->msgSignature = $msgSignature;
    }

    /**
     * @return GoodsDownShelfMessage
     */
    public function getMsgBody(): ?GoodsDownShelfMessage
    {
        return $this->msg_body;
    }

    /**
     * @param GoodsDownShelfMessage $msg_body
     */
    public function setMsgBody(?GoodsDownShelfMessage $msg_body): void
    {
        $this->msg_body = $msg_body;
    }

    /**
     * 微盟业务系统消息 ID，如智慧餐厅的订单编号
     * @var string
     */
    public $id;

    /**
     * 消息主题
     * @var string
     */
    public $topic;

    /**
     * 事件类型
     * @var string
     */
    public $event;

    /**
     * 商家 ID
     * @var string
     */
    public $business_id;

    /**
     * （新云）商家店铺 ID
     * @var string
     */
    private $public_account_id;

    /**
     * 防篡改签名：md5(client_id+id+client_secret)
     * @var string
     */
    public $sign;

    /**
     * 防篡改签名：md5(client_id+id+msg_body+client_secret)
     * @var string
     */
    public $msgSignature;

    /**
     * 业务消息体，编码格式 UTF-8
     * @var GoodsDownShelfMessage
     */
    private $msg_body;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class GoodsDownShelfMessage implements  \JsonSerializable
{
    /**
     * @return int
     */
    public function getGoodsId(): ?int
    {
        return $this->goodsId;
    }

    /**
     * @param int $goodsId
     */
    public function setGoodsId(?int $goodsId): void
    {
        $this->goodsId = $goodsId;
    }

    /**
     * @return int
     */
    public function getStoreId(): ?int
    {
        return $this->storeId;
    }

    /**
     * @param int $storeId
     */
    public function setStoreId(?int $storeId): void
    {
        $this->storeId = $storeId;
    }

    /**
     * @return string
     */
    public function getThirdGoodsId(): ?string
    {
        return $this->thirdGoodsId;
    }

    /**
     * @param string $thirdGoodsId
     */
    public function setThirdGoodsId(?string $thirdGoodsId): void
    {
        $this->thirdGoodsId = $thirdGoodsId;
    }
    /**
     * 菜品Id
     * @var int
     */
    private $goodsId;

    /**
     * 门店Id
     * @var int
     */
    private $storeId;

    /**
     * 菜品第三方编码
     * @var string
     */
    private $thirdGoodsId;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}