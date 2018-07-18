<?php

/**
 * Demo的通用入口文件
 *
 * Created by PhpStorm.
 * User: Sakura
 * Date: 17/12/5
 * Time: 下午2:54
 */

define('BASE_URL', dirname(__FILE__));
require_once BASE_URL . "/vendor/autoload.php";


$env = getenv('ENV_PARAMS');
if (empty($env)) {
    $env = 'stable';
}

$configFile = BASE_URL . "/config/web{$env}.ini";

$app = new \app\Application($configFile);
$app->run();