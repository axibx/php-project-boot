<?php

namespace WeimobCloudBoot\Com\Weimob\Cloud\Msg;

interface BosEmployeeStatusUpdateListener
{
    const classType = UpdateMessage::class;
    public function onMessage(WeimobMessage $message) : WeimobMessageAck;
}
class WeimobMessage implements \JsonSerializable
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
    public function getBosId(): ?string
    {
        return $this->bosId;
    }

    /**
     * @param string $bosId
     */
    public function setBosId(?string $bosId): void
    {
        $this->bosId = $bosId;
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
     * @return UpdateMessage
     */
    public function getMsgBody(): ?UpdateMessage
    {
        return $this->msgBody;
    }

    /**
     * @param UpdateMessage $msgBody
     */
    public function setMsgBody(?UpdateMessage $msgBody): void
    {
        $this->msgBody = $msgBody;
    }
    /**
     * 微盟业务系统消息 ID，如智慧餐厅的订单编号
     * @var string
     */
    var $id;

    /**
     * 消息主题名称
     * @var string
     */
    var $topic;

    /**
     * 消息事件名称
     * @var string
     */
    var $event;

    /**
     * 微盟新商业操作系统 ID
     * @var string
     */
    var $bosId;

    /**
     * 防篡改签名：md5(clientId+id+msgBody+clientSecret)
     * @var string
     */
    var $sign;

    /**
     * 业务消息体
     * @var UpdateMessage
     */
    var $msgBody;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class UpdateMessage implements \JsonSerializable
{
    /**
     * @return int
     */
    public function getWid(): int
    {
        return $this->wid;
    }

    /**
     * @param int $wid
     */
    public function setWid(?int $wid): void
    {
        $this->wid = $wid;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }
    /**
     * @var int
     */
    private $wid;

    /**
     * @var int
     */
    private $status;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class WeimobMessageAck implements \JsonSerializable
{
    /**
     * @return Code
     */
    public function getCode(): ?Code
    {
        return $this->code;
    }

    /**
     * @param Code $code
     */
    public function setCode(?Code $code): void
    {
        $this->code = $code;
    }
    /**
     * @var Code
     */
    private $code;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class Code implements \JsonSerializable
{
    /**
     * @return string
     */
    public function getErrcode(): ?string
    {
        return $this->errcode;
    }

    /**
     * @param string $errcode
     */
    public function setErrcode(?string $errcode): void
    {
        $this->errcode = $errcode;
    }

    /**
     * @return string
     */
    public function getErrmsg(): ?string
    {
        return $this->errmsg;
    }

    /**
     * @param string $errmsg
     */
    public function setErrmsg(?string $errmsg): void
    {
        $this->errmsg = $errmsg;
    }
    /**
     * 请求返回的状态码
     * @var string
     */
    var $errcode;

    /**
     * 请求返回的信息
     * @var string
     */
    var $errmsg;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}