<?php

namespace WeimobCloudBoot\Controller;

use Karriere\JsonDecoder\JsonDecoder;
use ReflectionClass;
use Slim\Http\Request;
use Slim\Http\Response;
use WeimobCloudBoot\Ability\Msg\MsgInfo;
use WeimobCloudBoot\Ability\Msg\MsgSubscription;
use WeimobCloudBoot\Ability\Msg\XinyunOpenMessage;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;

class XinyunMsgController extends BaseFramework
{
    public function handle(Request $request, Response $response, array $args){
        $msgBody = $request->getParsedBody();

        $jsonDecoder = new JsonDecoder();
        /** @var XinyunOpenMessage $xinyunOpenMessage */
        $xinyunOpenMessage = $jsonDecoder->decode(json_encode($msgBody), XinyunOpenMessage::class);
        $msgInfo = new MsgInfo($xinyunOpenMessage->getTopic(), $xinyunOpenMessage->getEvent());

        $specType = $xinyunOpenMessage->getSpecsType();
        if(empty($specType)){
            $specType = SpecTypeEnum::WOS;
        }

        $msgSubscription = $this->getContainer()->get("msgSubscription");

        /** @var MsgSubscription $msgSubscription */
        $msgInstance = $msgSubscription->getMsg($msgInfo, $specType);
        $methodName= SpecTypeEnum::MSG_METHOD_NAME;
        $result = $this->invokeMethod($msgInstance, $xinyunOpenMessage, $methodName, $xinyunOpenMessage->getMsgBody());

        return $response->withJson($result);
    }

    private function invokeMethod($msgInstance, XinyunOpenMessage $xinyunOpenMessage, $methodName, $msgBodyStr)
    {
        $ref = new ReflectionClass($msgInstance);
        $method = $ref->getMethod($methodName);
        $parameters = $method->getParameters();
        $parameterType = $parameters[0]->getType();

        $refParamClass = new ReflectionClass($parameterType->getName());
        $paramInstance = $refParamClass->newInstanceWithoutConstructor();

        $busiParamType = $ref->getConstant("classType");

        $jsonDecoder = new JsonDecoder();
        $jsonDecoder->scanAndRegister($busiParamType);
        $busiParamInstance = $jsonDecoder->decode($msgBodyStr, $busiParamType);
        $paramInstance->setId($xinyunOpenMessage->getId());
        $paramInstance->setTopic($xinyunOpenMessage->getTopic());
        $paramInstance->setEvent($xinyunOpenMessage->getEvent());
        $paramInstance->setBusinessId($xinyunOpenMessage->getBusinessId());
        $paramInstance->setPublicAccountId($xinyunOpenMessage->getPublicAccountId());
        $paramInstance->setSign($xinyunOpenMessage->getSign());
        $paramInstance->setMsgSignature($xinyunOpenMessage->getMsgSignature());
        $paramInstance->setMsgBody($busiParamInstance);

        return $method->invoke($msgInstance, $paramInstance);
    }
}