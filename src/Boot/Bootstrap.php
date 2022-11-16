<?php

namespace WeimobCloudBoot\Boot;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Container;
use WeimobCloudBoot\Ability\Msg\MsgSubscription;
use WeimobCloudBoot\Ability\Spi\SpiRegistry;
use WeimobCloudBoot\Component\Http\HttpClientWrapper;
use WeimobCloudBoot\Component\Log\WeimobCloudLogger;
use WeimobCloudBoot\Component\Store\PDOFactory;
use WeimobCloudBoot\Component\Store\RedisFactory;
use WeimobCloudBoot\Controller\HealthCheckController;
use WeimobCloudBoot\Controller\TokenController;
use WeimobCloudBoot\Controller\WosMsgController;
use WeimobCloudBoot\Controller\WosSpiController;
use WeimobCloudBoot\Controller\XinyunMsgController;
use WeimobCloudBoot\Controller\XinyunSpiController;
use WeimobCloudBoot\Daemon\Registry\IntervalTimerRegistry;
use WeimobCloudBoot\Util\ApolloUtil;
use WeimobCloudBoot\Util\EnvUtil;
use WeimobCloudBoot\Util\ObjectConvertUtil;
use WeimobCloudBoot\Component\Oauth\AccessToken;
use WeimobCloudBoot\Component\Encryption\DataSecurity;

class Bootstrap
{
    public static function setupContainer(): ContainerInterface
    {
        $container = new Container();

        $container['envUtil'] = function (ContainerInterface $container) {
            return new EnvUtil($container);
        };
        $container['logger'] = function (ContainerInterface $container) {
            /** @var EnvUtil $envUtil */
            $envUtil = $container->get('envUtil');
            $applicationName = $envUtil->getAppId();
            $logger = new WeimobCloudLogger($applicationName ?? "weimob-cloud-boot-default");

            //控制台输出
            $logger->pushHandler(new StreamHandler('php://stdout', $envUtil->getLogLevel()));

            // 异常捕获
            $logger->setExceptionHandler(function (\Exception $e, array $record) {

            });

            return $logger;
        };
        $container['httpClient'] = function (ContainerInterface $container) {
            return new HttpClientWrapper($container);
        };
        $container['apolloUtil'] = function (ContainerInterface $container) {
            return new ApolloUtil($container);
        };
        $container['pdoFactory'] = function (ContainerInterface $container) {
            return new PDOFactory($container);
        };
        $container['redisFactory'] = function (ContainerInterface $container) {
            return new RedisFactory($container);
        };
        $container['weimobCloudMysql'] = function (ContainerInterface $container) {
            return $container->get('pdoFactory')->buildBuiltinMySQLInstance();
        };
        $container['weimobCloudRedis'] = function (ContainerInterface $container) {
            return $container->get('redisFactory')->buildBuiltinRedisInstance();
        };
        $container['spiRegistry'] = function (ContainerInterface $container) {
            return new SpiRegistry($container);
        };
        $container['objectConvertUtil'] = function (ContainerInterface $container) {
            return new ObjectConvertUtil($container);
        };
        $container['msgSubscription'] = function (ContainerInterface $container) {
            return new MsgSubscription($container);
        };
        $container['accessToken'] = function (ContainerInterface $container) {
            return new AccessToken($container);
        };
        $container['dataDES'] = function (ContainerInterface $container) {
            return new DataSecurity($container);
        };
        return $container;
    }

    public static function setupApp(App $app): void
    {
        //健康检查
        $app->get(
            "/health_check",
            HealthCheckController::class . ':handle'
        );
        // TokenController
        $app->get(
            "/token",
            TokenController::class . ':handle'
        );
        //wos spi入口
        $app->post(
            "/weimob/cloud/spi/{beanName}",
            WosSpiController::class . ':handle'
        );

        //新云 spi入口
        $app->post(
            "/{serviceName}/{methodName}",
            XinyunSpiController::class . ':handle'
        );

        //wos 消息入口
        $app->post(
            "/weimob/cloud/wos/message/receive",
            WosMsgController::class . ':handle'
        );

        //新云 消息入口
        $app->post(
            "/weimob/ext/message/receive",
            XinyunMsgController::class . ':handle'
        );
    }

}