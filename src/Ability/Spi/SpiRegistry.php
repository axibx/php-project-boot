<?php
namespace WeimobCloudBoot\Ability\Spi;

use ReflectionClass;
use WeimobCloudBoot\Ability\AbilityRemoteRegistry;
use WeimobCloudBoot\Ability\SpecTypeEnum;
use WeimobCloudBoot\Ability\Spi\SpiSpecTypeEnum;
use WeimobCloudBoot\Boot\BaseFramework;
use WeimobCloudBoot\Exception\BeanRegisterException;

class SpiRegistry extends BaseFramework
{
    use AbilityRemoteRegistry;
	private $beanPool = [];

	public function register($spiInfo, $class, $spiVersion = null): void
    {
        if($this->existSpi($spiInfo,$spiVersion))
        {
            throw new BeanRegisterException("this spi is already registered");
        }

        if(!$this->canProcess($class, $spiVersion))
        {
            return;
        }

        $this->registerServiceInfo($spiInfo, $class, $spiVersion);
        $this->beanPool[$this->getSpiKey($spiInfo,$spiVersion)] = ["spiInfo"=>$spiInfo,"instanceClass"=>$class,"spiVersion"=>$spiVersion];
    }

    public function getSpi($spiInfo, $spiVersion = null): BaseFramework
    {
        if(!$this->existSpi($spiInfo,$spiVersion))
        {
            throw new BeanRegisterException("this spi maybe not impl");
        }
        $spi = $this->beanPool[$this->getSpiKey($spiInfo,$spiVersion)];
        $class = $spi["instanceClass"];

        return new $class($this->getContainer());
    }

    private function existSpi($spiInfo,$spiVersion): bool
    {
        if(!isset($spiInfo) or empty($spiInfo))
        {
            throw new BeanRegisterException("spiInfo is empty");
        }
        if(!isset($spiVersion) or empty($spiVersion))
        {
            $spiVersion = SpecTypeEnum::WOS;
        }
        return isset($this->beanPool[$this->getSpiKey($spiInfo,$spiVersion)]);
    }

    private function getSpiKey($spiInfo,$spiVersion): string
    {
        return $spiInfo.'_'.(empty($spiVersion)?SpecTypeEnum::WOS : $spiVersion);
    }

    private function canProcess($class, $spiVersion): bool
    {

        $spiInterface = $this->getSpiInterface($class, $spiVersion);
        if(empty($spiInterface)){
            return false;
        }

        if($spiVersion === null or $spiVersion === SpecTypeEnum::WOS){
            $methodName = SpecTypeEnum::WOS_SPI_METHOD_NAME;
        }else{
            $methodName = SpecTypeEnum::XINYUN_SPI_METHOD_NAME;
        }

        $ref = new ReflectionClass($class);
        //todo 异常处理
        $method = $ref->getMethod($methodName);
        if(empty($method)){
            return false;
        }

        /*
        $parameters = $method->getParameters();
        $parameterType = $parameters[0]->getType();

        if($spiVersion === null or $spiVersion === SpecTypeEnum::WOS) {
            if (!$parameterType instanceof PaasRequest)
            {
                return false;
            }
        }else{
            if (!$parameterType instanceof CommonRequestVo)
            {
                return false;
            }
        }
        */

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
            $interfacePath = SpecTypeEnum::WOS_SPI_INTERFACE_CLASS_PACKAGE;
        }else{
            $interfacePath = SpecTypeEnum::XINYUN_SPI_INTERFACE_CLASS_PACKAGE;
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

    private function registerServiceInfo($spiInfo, $class, $spiVersion)
    {
        $ref = new ReflectionClass($class);

        $spiRegistryInfoDTO = new SpiRegistryInfoDTO();
        $spiRegistryInfoDTO->setImplFullName($ref->getName());
        $spiRegistryInfoDTO->setBeanName($spiInfo);
        $spiInterface = $this->getSpiInterface($class, $spiVersion);
        if(!empty($spiInterface)) {
            $pos = strripos($spiInterface,'\\');
            if($pos !== false) {
                $spiRegistryInfoDTO->setInterfaceName(substr($spiInterface,$pos+1));
            }
        }
        $spiRegistryInfoDTO->setMethodName(SpecTypeEnum::XINYUN_SPI_METHOD_NAME);
        $spiRegistryInfoDTO->setSpiBelongType($spiVersion);

        $registryDTO = new RegistryDTO();
        $registryDTO->setInterfacePathVos($spiRegistryInfoDTO);

        $this->registerRemote($registryDTO);
    }


}