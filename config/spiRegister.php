<?php
/** @var WeimobCloudBoot\Ability\Spi\SpiRegistry $spiRegistry */

use WeimobCloudBoot\Ability\SpecTypeEnum;

$spiRegistry->register("demoSpiImpl",\WeimobCloudBoot\Ability\Spi\DemoSpiImpl::class,SpecTypeEnum::WOS);
$spiRegistry->register("demoSpiImpl",\WeimobCloudBoot\Ability\Spi\DemoXinyunSpiImpl::class,SpecTypeEnum::XINYUN);