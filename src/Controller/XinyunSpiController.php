<?php

namespace WeimobCloudBoot\Controller;

use Karriere\JsonDecoder\JsonDecoder;
use ReflectionClass;
use Slim\Http\Request;
use Slim\Http\Response;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;

/**
 * 新云 spi入口
 */
class XinyunSpiController extends BaseFramework
{
    public function handle(Request $request, Response $response, array $args){
        $beanName = $args['serviceName'];
        $methodName= SpecTypeEnum::XINYUN_METHOD_NAME;

        $pidStr = $request->getHeader('saas-pid');
        if(count($pidStr)>0){
            $pidStr = $pidStr[0];
        }
        $spiRegistry = $this->getContainer()->get("spiRegistry");

        /** @var \WeimobCloudBoot\Ability\Spi\SpiRegistry $spiRegistry */
        $spiInstance = $spiRegistry->getSpi($beanName, SpecTypeEnum::XINYUN);
        $spiBody = $request->getBody();

        $result = $this->invokeMethod($spiInstance, $methodName, $spiBody, $pidStr);
        return $response->withJson(json_encode($result));
    }

    private function invokeMethod($spiInstance, $methodName, $spiBody, $pidStr)
    {
        $spiClass = get_class($spiInstance);
        $ref = new ReflectionClass($spiClass);
        $method = $ref->getMethod($methodName);
        $parameters = $method->getParameters();
        $parameterType = $parameters[0]->getType();

        $jsonDecoder = new JsonDecoder();
        $jsonDecoder->scanAndRegister($parameterType);
        $tempObj = $jsonDecoder->decode($spiBody,$parameterType);

        if (!empty($pidStr) && is_numeric($pidStr)) {
            $pid = (int)$pidStr;
            $tempObj->setPid($pid);
        }

        return $method->invoke($spiInstance, $tempObj);
    }
}