<?php

namespace WeimobCloudBoot\Ability\Spi;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\PaasResponseCode;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\Xinyun\PaasWeimobShopCouponPaasBatchLockCouponResponse;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\Xinyun\XinyunPaasWeimobShopCouponPaasBatchLockCouponRequest;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\Xinyun\XinyunPaasWeimobShopCouponPaasBatchLockCouponResponse;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\Xinyun\XinyunPaasWeimobShopCouponPaasBatchLockCouponService;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\XinyunWeimobShopCouponPaasBatchLockCouponRequest;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\XinyunWeimobShopCouponPaasBatchLockCouponResponse;

class DemoXinyunSpiImpl extends BaseFramework implements XinyunPaasWeimobShopCouponPaasBatchLockCouponService
{

    public function excute(XinyunPaasWeimobShopCouponPaasBatchLockCouponRequest $request): XinyunPaasWeimobShopCouponPaasBatchLockCouponResponse
    {
        $paasResponse = new XinyunPaasWeimobShopCouponPaasBatchLockCouponResponse();
        $paasResponseCode = new PaasResponseCode();
        $paasResponseCode->setErrcode("success");
        $paasResponseCode->setErrmsg("成功");

        $paasResponse->setCode($paasResponseCode);
        $paasResponse->setData(true);
        return $paasResponse;
    }
}