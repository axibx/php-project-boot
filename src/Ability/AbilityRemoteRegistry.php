<?php

namespace WeimobCloudBoot\Ability;

use WeimobCloudBoot\Ability\Spi\RegistryDTO;

trait AbilityRemoteRegistry
{
    public function registerRemote(RegistryDTO $registryDTO)
    {
        /** @var \WeimobCloudBoot\Util\EnvUtil $envUtil */
        $envUtil = $this->getContainer()->get("envUtil");
        $clientInfos = $envUtil->getClientInfos();
        foreach ($clientInfos as $key=>$val)
        {
            $messageExtensionDto = $registryDTO->getMessageExtensionDTO();
            if(!empty($messageExtensionDto)){
                $messageExtensionDto->setClientId($clientInfos[$key]["clientId"]);
            }
            $this->registerRemoteWithClient($registryDTO, $clientInfos[$key]);
        }
    }

    private function registerRemoteWithClient(RegistryDTO $registryDTO, $clientInfo):void
    {
        /** @var \WeimobCloudBoot\Util\EnvUtil $envUtil */
        $envUtil = $this->getContainer()->get("envUtil");
        $postUrl = $envUtil->getPostUrl();
        if (empty($postUrl)) {
            return;
        }
        /** @var \WeimobCloudBoot\Util\EnvUtil $envUtil */
        $envUtil = $this->getContainer()->get("envUtil");

        $clientId = $clientInfo['clientId'];
        $clientSecret = $clientInfo['clientSecret'];
        $registryDTO->setClientId($clientId);
        $registryDTO->setSdkVersion($envUtil->getSdkVersion());

        $appId = $envUtil->getWeimobCloudAppId();
        $env = $envUtil->getEnv();
        $param = json_encode($registryDTO);
        $timestamp = (string)time();
        $builder = $clientId.$clientSecret.$timestamp.md5($param);
        $sign = md5($builder);

        $myArray = ["sign"=>$sign, "timestamp"=>$timestamp, "clientId"=>$clientId, "appId"=>$appId, "env"=>$env, "params"=>$param];

        $client = $this->getContainer()->get('httpClient');
        $r = $client->post($postUrl, null, json_encode($myArray));
        $response = $r->getBody();
    }
}