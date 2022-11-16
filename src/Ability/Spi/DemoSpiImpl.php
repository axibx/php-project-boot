<?php

namespace WeimobCloudBoot\Ability\Spi;

use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\PaasResponseCode;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\PaasWeimobShopCouponPaasBatchLockCouponService;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\WeimobShopCouponPaasBatchLockCouponData;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\WeimobShopCouponPaasBatchLockCouponRequest;
use WeimobCloudBoot\Com\Weimob\Cloud\Spi\WeimobShopCouponPaasBatchLockCouponResponse;

class DemoSpiImpl extends BaseFramework implements PaasWeimobShopCouponPaasBatchLockCouponService
{

    public function invoke(WeimobShopCouponPaasBatchLockCouponRequest $request): WeimobShopCouponPaasBatchLockCouponResponse
    {
        $paasResponse = new WeimobShopCouponPaasBatchLockCouponResponse();
        $paasResponseCode = new PaasResponseCode();
        $paasResponseCode->setErrcode("success");
        $paasResponseCode->setErrmsg("成功");

        $data = new WeimobShopCouponPaasBatchLockCouponData();
        $data->setAge(11);
        $data->setName("test");
        $paasResponse->setData($data);
        $paasResponse->setCode($paasResponseCode);

        return $paasResponse;
    }
}