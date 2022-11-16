<?php

namespace WeimobCloudBoot\Ability;

class SpecTypeEnum
{
    const XINYUN = 1;
    const WOS = 2;
    const WOS_METHOD_NAME = "invoke";
    const XINYUN_METHOD_NAME = "excute";

    const WOS_SPI_INTERFACE_CLASS_PACKAGE = 'WeimobCloudBoot\Com\Weimob\Cloud\Spi';
    const XINYUN_SPI_INTERFACE_CLASS_PACKAGE = 'WeimobCloudBoot\Com\Weimob\Cloud\Spi';

    const WOS_MSG_INTERFACE_CLASS_PACKAGE = 'WeimobCloudBoot\Com\Weimob\Cloud\Msg';
    const XINYUN_MSG_INTERFACE_CLASS_PACKAGE = 'WeimobCloudBoot\Com\Weimob\Cloud\Msg';

    const MSG_METHOD_NAME='onMessage';

    const SDK_VERSION_V1 = "v1";
    const SDK_VERSION_V2 = "v2";
}