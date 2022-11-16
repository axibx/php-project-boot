<?php

namespace WeimobCloudBoot\Ability\Msg;

use ReflectionClass;
use WeimobCloudBoot\Ability\AbilityRemoteRegistry;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Ability\Spi\RegistryDTO;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Exception\BeanRegisterException;

class MsgSubscription extends BaseFramework
{
    use AbilityRemoteRegistry;
	private $beanPool = [];

    /**
     * @param $msgInfo
     * @param $class
     * @param $msgVersion
     * @return void
     * @throws BeanRegisterException
     */
	public function subscribe($msgInfo, $class, $msgVersion = null): void
    {
        /** @var MsgInfo  $msgInfo */
        if($this->existMsg($msgInfo,$msgVersion))
        {
            throw new BeanRegisterException("this msg is already registered");
        }

        if(!$this->canProcess($class, $msgVersion))
        {
            return;
        }

        $this->registerServiceInfo($msgInfo, $class, $msgVersion);
        $this->beanPool[$this->getMsgKey($msgInfo,$msgVersion)] = ["msgInfo"=>$msgInfo,"instanceClass"=>$class,"msgVersion"=>$msgVersion];
    }

    public function getMsg($msgInfo, $msgVersion = null): BaseFramework
    {
        if(!$this->existMsg($msgInfo,$msgVersion))
        {
            throw new BeanRegisterException("this msg maybe not impl");
        }
        $msg = $this->beanPool[$this->getMsgKey($msgInfo,$msgVersion)];
        $class = $msg["instanceClass"];

        return new $class($this->getContainer());
    }

    private function existMsg($msgInfo,$msgVersion): bool
    {
        if(!isset($msgInfo) or empty($msgInfo))
        {
            throw new BeanRegisterException("msgInfo is empty");
        }
        if(!isset($msgVersion) or empty($msgVersion))
        {
            $msgVersion = SpecTypeEnum::WOS;
        }
        return isset($this->beanPool[$this->getMsgKey($msgInfo,$msgVersion)]);
    }

    private function getMsgKey($msgInfo,$msgVersion): string
    {
        /** @var MsgInfo  $msgInfo */
        return $msgInfo->getTopic().'#'.$msgInfo->getEvent().'#'.(empty($spiVersion)?SpecTypeEnum::WOS : $msgVersion);
    }

    private function canProcess($class, $msgVersion): bool
    {

        $spiInterface = $this->getSpiInterface($class, $msgVersion);
        if(empty($spiInterface)){
            return false;
        }

        $methodName = SpecTypeEnum::MSG_METHOD_NAME;

        $ref = new ReflectionClass($class);
        $method = $ref->getMethod($methodName);
        if(empty($method)){
            return false;
        }
        $parameters = $method->getParameters();
        if(count($parameters) != 1){
            return false;
        }

        return true;
    }

    /**
     * 获取类实现的spi接口
     * @param $class
     * @param $spiVersion
     * @return string|null
     */
    private function getSpiInterface($class, $spiVersion): ?string
    {
        $interfaceArray = class_implements($class);
        if($spiVersion === null or $spiVersion === SpecTypeEnum::WOS){
            $interfacePath = SpecTypeEnum::WOS_MSG_INTERFACE_CLASS_PACKAGE;
        }else{
            $interfacePath = SpecTypeEnum::XINYUN_MSG_INTERFACE_CLASS_PACKAGE;
        }

        foreach ($interfaceArray as $key=>$value)
        {
            if(strncmp($interfacePath, $key, strlen($interfacePath))===0)
            {
                return $key;
            }
        }
        return null;
    }

    private function registerServiceInfo($msgInfo, $class, $spiVersion)
    {
        /** @var \WeimobCloudBoot\Util\EnvUtil $envUtil */
        $envUtil = $this->getContainer()->get("envUtil");

        $messageRegistryInfoDTO = new MessageRegistryInfoDTO();
        //$messageRegistryInfoDTO->setHostAddress($envUtil->getHostName());
        $messageRegistryInfoDTO->setHostAddress("192.168.200.100");
        if($spiVersion === null or $spiVersion === SpecTypeEnum::WOS){
            $messageRegistryInfoDTO->setPath("weimob/cloud/wos/message/receive");
            $messageRegistryInfoDTO->setSpecsType(SpecTypeEnum::WOS);
        }else{
            $messageRegistryInfoDTO->setPath("weimob/ext/message/receive");
            $messageRegistryInfoDTO->setSpecsType(SpecTypeEnum::XINYUN);
        }


        $registryDTO = new RegistryDTO();
        $registryDTO->setMessageExtensionDTO($messageRegistryInfoDTO);
        $registryDTO->setInterfacePathVos([]);

        $this->registerRemote($registryDTO);
    }
}