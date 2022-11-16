<?php

namespace WeimobCloudBootTest\Component\Store;

use PDO;
use WeimobCloudBoot\Component\Store\PDOFactory;
use WeimobCloudBootTest\Base\BaseTestCase;

class PDOTest extends BaseTestCase
{
    public static function setUpBeforeClass() {
        $_SERVER['mysql_host'] = '127.0.0.1';
        $_SERVER['mysql_port'] = "3306";
        $_SERVER['mysql_username'] = 'root';
        $_SERVER['mysql_password'] = 'test1234';

        define('WMCLOUD_BOOT_APP_DIR', realpath(__DIR__ . '/../../'));
    }

    public function test()
    {
        /** @var PDOFactory $pdoFactory */
        $pdoFactory = $this->getApp()->getContainer()->get('pdoFactory');

        $pdo = $pdoFactory->buildBuiltinMySQLInstance();
        $this->assertNotNull($pdo);

        $stmt = $pdo->prepare('create database `test_weimobcloud_db`');
        $r = $stmt->execute();
        $this->assertTrue($r);

        /** @var PDO $weimobCloudMysql */
        $weimobCloudMysql = $this->getApp()->getContainer()->get('weimobCloudMysql');
        $this->assertNotNull($weimobCloudMysql);

        $stmt = $weimobCloudMysql->prepare('drop database `test_weimobcloud_db`');
        $r = $stmt->execute();
        $this->assertTrue($r);
    }
}