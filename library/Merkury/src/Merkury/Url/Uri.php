<?php

namespace Merkury\Url;

class Uri
{
    private $_uri;
    private $_controller;
    private $_action;
    private $_matches = [];
    private $_where = [];


    public function __construct($uri, $controller, $action)
    {
        $this->_uri = trim($uri, '/');
        $this->_controller = $controller;
        $this->_action = $action;
    }

    public function where($param, $regex)
    {
        $this->_where[$param] = $regex;
    }

    public function match($request_uri)
    {
        list($uri,) = explode('?', $request_uri);

        $this->_uri = preg_replace_callback(
                '/\{(.+)\}/U', 
                array($this, 'replaceSpecialMatchesByRegularExpression') , 
                $this->_uri
      );

        $res = preg_match('/^'. $this->escapeSlash($this->_uri) . '$/', trim($uri, '/'), $this->_matches);
        return (bool)$res;
    }

    public function getMatches()
    {
        return $this->_matches;
    }

    public function getControllerName()
    {
        return $this->_controller;
    }

    public function getActionName()
    {
        return $this->_action;
    }

    private function replaceSpecialMatchesByRegularExpression($matched)
    {
        $param = $matched[1];
        $regex = isset($this->_where[$param]) ? $this->_where[$param] : '.*';

        return sprintf('(?P<%s>%s)', $param, $regex);
    }

    private function escapeSlash($str)
    {
        return str_replace('/', '\/', $str);
    }
}
