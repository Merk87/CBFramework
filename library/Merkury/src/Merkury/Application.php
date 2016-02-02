<?php

namespace Merkury;

class Application
{
    /**
     * @var Http\Request
     */
    private $_request;
    /**
     * @var Http\Response
     */
    private $_response;
    /**
     * @var Url\Uri
     */
    private $_uri;
    /**
     * @var Controller
     */
    private $_controller;

    public function __construct()
    {
        $this->_request = new Http\Request();
        $this->_response = new Http\Response();
    }

    public function run()
    {
        if($this->_isRequestMatching()){
            $this->_controller = $this->_getControllerInstance();
            $this->_response->setBody($this->_callAction());
            $this->_response->send();
        }
    }

    private function _isRequestMatching()
    {
        try{
            if(Url\Route::match($this->_request)){
                return $this->_uri = Url\Route::match($this->_request);
            }else{
                throw new \Exception('404 Not found');
            }
        }catch(\Exception $e){
            echo $e->getMessage();
            exit;
        }
    }

    private function _getControllerInstance()
    {
        $controller = $this->_uri->getControllerName();

        return new $controller($this->_request, $this->_response);
    }

    private function _callAction()
    {
        return call_user_func_array(
                array($this->_controller, $this->_uri->getActionName()),
                $this->_getActionParams()
      );
    }

    private function _getActionParams()
    {
        $params = [];
        $matches = $this->_uri->getMatches();
        $reflection_method = new \ReflectionMethod($this->_controller, $this->_uri->getActionName());

        /* @var $parameter \ReflectionParameter */
        foreach ($reflection_method->getParameters() as $parameter){
            if(isset($matches[$parameter->getName()]))
                $params[] = $matches[$parameter->getName()];
        }
        return $params;
    }
}
