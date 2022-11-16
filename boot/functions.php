<?php

function init()
{
    // 推定的工程目录
    //$assumedAppDir = realpath(__DIR__ . '/../../../..');
    $assumedAppDir = "D:\phpproject\php-project-boot2";

    // 检查是在项目运行还是独立运行(例如测试)，判断依据是 composer.json 和 env.php
    if (file_exists($assumedAppDir . '/composer.json') and file_exists($assumedAppDir . '/config/env.php')) {
        require_once($assumedAppDir . '/config/env.php');
    }

    // 如果是项目运行，加载项目目录下 vendor 的 autoload, 否则在自身目录下面寻找 vendor 下的 autoload
    if (defined('WMCLOUD_BOOT_APP_DIR')) {
        require_once(WMCLOUD_BOOT_APP_DIR . '/vendor/autoload.php');
    } else {
        require_once(__DIR__ . '/../vendor/autoload.php');
    }
}

function fixDevelopServer()
{
    if (isset($_SERVER['SERVER_SOFTWARE']) and preg_match('/^PHP.+Development Server$/', $_SERVER['SERVER_SOFTWARE'])) {
        // 如果确实存在文件，返回文件
        if (file_exists($_SERVER['SCRIPT_NAME'])) {
            return false;
        }
        // 否则则将错误的 PHP_SELF 和 SCRIPT_NAME 重写为 index.php
        $_SERVER['PHP_SELF'] = '/index.php';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
    }
}