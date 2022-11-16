<?php
/** @var WeimobCloudBoot\Ability\Msg\MsgSubscription $msgSubscription */

use WeimobCloudBoot\Ability\Msg\MsgInfo;
use WeimobCloudBoot\Ability\SpecTypeEnum;

$msgSubscription->subscribe(new MsgInfo("bos.employee.status","update"),\WeimobCloudBoot\Ability\Msg\DemoMsgImpl::class,SpecTypeEnum::WOS);
$msgSubscription->subscribe(new MsgInfo("o2o_store_goods","goodsDownShelf"),\WeimobCloudBoot\Ability\Msg\DemoXinyunMsgImpl::class,SpecTypeEnum::XINYUN);
