<?php

namespace WeimobCloudBoot\Controller;

use JsonMapper;
use ReflectionClass;
use Slim\Http\Request;
use Slim\Http\Response;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Util\ObjectConvertUtil;

/**
 * wos spi入口
 */
class WosSpiController extends BaseFramework
{
    public function handle(Request $request, Response $response, array $args){
        $beanName = $args['beanName'];
        $methodName= SpecTypeEnum::WOS_SPI_METHOD_NAME;

        $spiRegistry = $this->getContainer()->get("spiRegistry");

        /** @var \WeimobCloudBoot\Ability\Spi\SpiRegistry $spiRegistry */
        $spiInstance = $spiRegistry->getSpi($beanName, SpecTypeEnum::WOS);
        $spiBody = $request->getBody();

        $result = $this->invokeMethod($spiInstance, $methodName, $spiBody);
        return $response->withJson(json_encode($result));
    }

    private function invokeMethod($spiInstance, $methodName, $spiBody)
    {


        $spiClass = get_class($spiInstance);
        $ref = new ReflectionClass($spiClass);
        $method = $ref->getMethod($methodName);
        $parameters = $method->getParameters();
        $parameterType = $parameters[0]->getType();

        $tempArray = (array)json_decode(json_encode($spiBody));

        $jsonDecoder = new JsonMapper();
        $tempObj = $jsonDecoder->map(json_decode($spiBody),new $parameterType());

        //$params = $tempArray['params'];

        //$objectConvertUtil = $this->getContainer()->get('objectConvertUtil');


        /** @var ObjectConvertUtil $objectConvertUtil */
        /*
        $paramsObj = $objectConvertUtil->convertToMethodParameter($method, $tempArray);
        $paramsObj->setBosId($tempArray['bosId']);
        $paramsObj->setFunctionId($tempArray['functionId']);
        $paramsObj->setVid($tempArray['vid']);
        $paramsObj->setVType($tempArray['vType']);
        $paramsObj->setParams($paramsObj);
        */

        return $method->invoke($spiInstance, $tempObj);
    }
}