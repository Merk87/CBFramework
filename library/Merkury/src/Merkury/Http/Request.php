<?php

namespace Merkury\Http;

class Request
{

    private $_get;
    private $_post;
    private $_request;
    private $_cookie;
    private $_server;

    public function __construct()
    {
        $this->_get = $_GET;
        $this->_post = $_POST;
        $this->_cookie = $_COOKIE;
        $this->_server = $_SERVER;
        $this->_request = $_REQUEST;
    }

    public function isPost()
    {
        return $this->_server['REQUEST_METHOD'] === 'POST';
    }

    public function getParams()
    {
        return $this->_request;
    }

    public function getParam($key, $fallback_value = false)
    {
        if(isset($this->_request[$key]))
            return $this->_request[$key];

        return $fallback_value;
    }

    public function getPostParams(){
        return $this->_post;
    }

    public function __call($name, $arguments)
    {
        $globals_bag = '_' . $name;
        $key = current($arguments);

        if(isset($this->{ $globals_bag }[$key]))
            return $this->{ $globals_bag }[$key];
    }
}
