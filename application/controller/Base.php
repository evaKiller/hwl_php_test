<?php
/**
 * Created by PhpStorm.
 * User: Sakura
 * Date: 17/12/5
 * Time: 下午3:56
 */

namespace app\controller;

abstract class Base
{
    protected $requestId;


    public function __construct()
    {
        $this->requestId = uniqid();

        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Headers: x-requested-with,content-type");
        header("Access-Control-Allow-Methods: OPTIONS,POST,GET");
        $post = [];
        foreach ($_POST as $key => $value) {
            $post[lcfirst($key)] = $value;
        }
        $_POST = $post;
        //$this->log($_POST);
    }

    protected function log($info)
    {
        if (is_array($info) || is_object($info)) {
            $info = json_encode($info, JSON_UNESCAPED_UNICODE);
        }
        $log = sprintf("%s %s %s %s" . PHP_EOL,
            date("YmdHis"),
            $this->requestId,
            __CLASS__ . '.' . __METHOD__,
            $info
        );
        file_put_contents(BASE_URL . '/log/api.log', $log, FILE_APPEND);
    }

    public function toJson($res)
    {
        header('Content-Type: application/json');
        //$this->log($res);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        exit;
    }

}
