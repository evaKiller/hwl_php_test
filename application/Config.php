<?php

namespace app;

class Config
{
    private $_config = [];

    public function __get($name)
    {
        if(isset($this->_config[$name])) {
            return $this->_config[$name];
        }
        throw  new \Exception('config not exists');
    }

    public function __set($name, $value)
    {
        $this->_config[$name] = $value;
    }
}