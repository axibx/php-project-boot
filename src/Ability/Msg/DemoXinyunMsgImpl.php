<?php

namespace WeimobCloudBoot\Ability\Msg;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Com\Weimob\Cloud\Msg\Code;
use WeimobCloudBoot\Com\Weimob\Cloud\Msg\WeimobMessageAck;
use WeimobCloudBoot\Com\Weimob\Cloud\Msg\Xinyun\O2oStoreGoodsGoodsDownShelfListener;
use WeimobCloudBoot\Com\Weimob\Cloud\Msg\Xinyun\WeimobXinyunMessage;

class DemoXinyunMsgImpl extends BaseFramework implements O2oStoreGoodsGoodsDownShelfListener
{

    public function onMessage(WeimobXinyunMessage $message): WeimobMessageAck
    {
        $weimobMessageAck = new WeimobMessageAck();
        $code = new Code();
        $code->setErrcode("success");
        $code->setErrmsg("成功");
        $weimobMessageAck->setCode($code);

        return $weimobMessageAck;
    }
}