<?php

namespace WeimobCloudBoot\Ability\Msg;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Com\Weimob\Cloud\Msg\BosEmployeeStatusUpdateListener;
use WeimobCloudBoot\Com\Weimob\Cloud\Msg\Code;
use WeimobCloudBoot\Com\Weimob\Cloud\Msg\WeimobMessage;
use WeimobCloudBoot\Com\Weimob\Cloud\Msg\WeimobMessageAck;

class DemoMsgImpl extends BaseFramework implements BosEmployeeStatusUpdateListener
{

    public function onMessage(WeimobMessage $message): WeimobMessageAck
    {
        $weimobMessageAck = new WeimobMessageAck();
        $code = new Code();
        $code->setErrcode("success");
        $code->setErrmsg("成功");
        $weimobMessageAck->setCode($code);

        return $weimobMessageAck;
    }
}