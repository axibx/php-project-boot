<?php

require_once(__DIR__ . '/../boot/functions.php');

init();
fixDevelopServer();

$container = WeimobCloudBoot\Boot\Bootstrap::setupContainer();

// 初始化应用
$app = new \Slim\App($container);
WeimobCloudBoot\Boot\Bootstrap::setupApp($app);
WeimobCloudBoot\Facade\Facade::setFacadeApplication($app);

if (defined('WMCLOUD_BOOT_APP_DIR')) {
    // 这里使用匿名函数保证上下文干净，避免污染当前文件的变量


    (function () use ($app) {
        require(WMCLOUD_BOOT_APP_DIR . '/config/routes.php');
    })();

    (function () use ($app) {
        if (file_exists(WMCLOUD_BOOT_APP_DIR . '/config/middlewares.php')) {
            require(WMCLOUD_BOOT_APP_DIR . '/config/middlewares.php');
        }
    })();


    $spiRegistry = $container->get("spiRegistry");
    (function () use ($spiRegistry) {
        require(WMCLOUD_BOOT_APP_DIR . '/config/spiRegister.php');
    })();

    $msgSubscription = $container->get("msgSubscription");
    (function () use ($msgSubscription) {
        require(WMCLOUD_BOOT_APP_DIR . '/config/msgSubscription.php');
    })();
}

try {
    if ((isset($spiRegistry) and !$spiRegistry instanceof \WeimobCloudBoot\Ability\Spi\SpiRegistry)
        or (isset($msgSubscription) and !$msgSubscription instanceof \WeimobCloudBoot\Ability\Msg\MsgSubscription)
        or (!$app instanceof \Slim\App)) {
        //在 app 端有可能被修改实例，抛异常
        throw new Exception();
    }

    $app->run();
} catch (Exception $e) {
    // do something
}