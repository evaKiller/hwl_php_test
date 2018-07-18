<?php
namespace app;
/**
 * Created by PhpStorm.
 * User: Sakura
 * Date: 17/12/5
 * Time: 下午3:12
 */
class Application
{
    private $_controller;

    private $_action;

    private $config;

    private $_params;

    public static $app;

    public function __construct($configFile)
    {
        $this->config = new Config();
        $configs = parse_ini_file($configFile,true);
        foreach ($configs as $key => $value) {
            $this->config->$key = $value;
        }

        $controllerNameSpace = '\app\controller';
        $actionPrefix        = "action";
        $pathInfo            = explode('?', $_SERVER['REQUEST_URI']);
        $path                = substr($pathInfo[0], 1);
        if (count($pathInfo) > 1) {
            $this->_params = $pathInfo[1];
        }

        $uri = explode('/', $path);
        switch (count($uri)) {
            case 0:
                $this->_controller = $controllerNameSpace . '\Index';
                $this->_action     = $actionPrefix . 'Index';
                break;
            case 1:
                if (empty($uri[0])) {
                    $this->_controller = $controllerNameSpace . '\Index';
                } else {
                    $this->_controller = $controllerNameSpace . '\\' . ucfirst($uri[0]);
                }
                $this->_action = $actionPrefix . 'Index';
                break;
            default:
                $this->_controller = $controllerNameSpace . '\\' . ucfirst($uri[0]);
                $this->_action     = $actionPrefix . ucfirst($uri[1]);
        }

        set_error_handler("\\app\\Application::exception");
        //set_exception_handler("\\app\\Application::exception");
        self::$app = $this;
    }

    public function run()
    {
        $controller = new $this->_controller;
        call_user_func([$controller, $this->_action], $this->_params);
    }

    public function getConfig($key)
    {
        return $this->config->$key;
    }

    public static function exception($errno, $errstr, $errfile, $errline)
    {
        file_put_contents(BASE_URL."/log/error.log",<<<EOT
        {$errno} : {$errstr}
        File: {$errfile}
        Line: {$errline}
EOT
,FILE_APPEND);
        echo <<<EOT
{$errno} : {$errstr}<br />
File: {$errfile}<br />
Line: {$errline}<br />
<br />
EOT;
        exit();
    }
}
