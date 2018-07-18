<?php

namespace app\controller;
use app\Application;

class Index extends Base
{
    function actionIndex()
    {
        $config = Application::$app->getConfig('mysql');
        var_dump($config);
    }

}