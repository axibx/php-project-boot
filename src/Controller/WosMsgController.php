<?php

namespace WeimobCloudBoot\Controller;

use JsonMapper;
use ReflectionClass;
use Slim\Http\Request;
use Slim\Http\Response;
use WeimobCloudBoot\Ability\Msg\MsgInfo;
use WeimobCloudBoot\Ability\Msg\MsgSubscription;
use WeimobCloudBoot\Ability\Msg\WosOpenMessage;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;


class WosMsgController extends BaseFramework
{
    public function handle(Request $request, Response $response, array $args){
        $msgBody = $request->getParsedBody();

        $jsonDecoder = new JsonMapper();
        /** @var WosOpenMessage $wosOpenMessage */
        $wosOpenMessage = $jsonDecoder->map($msgBody, new WosOpenMessage());
        $msgInfo = new MsgInfo($wosOpenMessage->getTopic(), $wosOpenMessage->getEvent());

        $specType = $wosOpenMessage->getSpecsType();
        if(empty($specType)){
            $specType = SpecTypeEnum::WOS;
        }

        $msgSubscription = $this->getContainer()->get("msgSubscription");

        /** @var MsgSubscription $msgSubscription */
        $msgInstance = $msgSubscription->getMsg($msgInfo, $specType);
        $methodName= SpecTypeEnum::MSG_METHOD_NAME;
        $result = $this->invokeMethod($msgInstance, $wosOpenMessage, $methodName, $wosOpenMessage->getMsgBody());

        return $response->withJson($result);
    }

    private function invokeMethod($msgInstance, WosOpenMessage $wosOpenMessage, $methodName, $msgBodyStr){
        $ref = new ReflectionClass($msgInstance);
        $method = $ref->getMethod($methodName);
        $parameters = $method->getParameters();
        $parameterType = $parameters[0]->getType();

        $refParamClass = new ReflectionClass($parameterType->getName());
        $paramInstance = $refParamClass->newInstanceWithoutConstructor();

        $busiParamType = $ref->getConstant("classType");

        $jsonDecoder = new JsonMapper();
        $busiParamInstance = $jsonDecoder->map(json_decode($msgBodyStr), new $busiParamType());
        $paramInstance->setId($wosOpenMessage->getId());
        $paramInstance->setTopic($wosOpenMessage->getTopic());
        $paramInstance->setEvent($wosOpenMessage->getEvent());
        $paramInstance->setBosId($wosOpenMessage->getBosId());

        $paramInstance->setSign($wosOpenMessage->getSign());
        $paramInstance->setMsgBody($busiParamInstance);

        return $method->invoke($msgInstance, $paramInstance);
    }
}