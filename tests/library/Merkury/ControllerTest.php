<?php

namespace Merkury;

require_once 'FooController.php';

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Http\Request
     */
    private  $_request;
    /**
     * @var Http\Response 
     */
    private $_response;

    public function setUp()
    {
        $this->_request = new Http\Request();
        $this->_response = new Http\Response();
        parent::setUp();
    }

    public function testCanInstanceFooController()
    {
        $this->assertInstanceOf('FooController', new \FooController($this->_request, $this->_response));
    }
    public function testCanUseReflectionOverFooController()
    {
        $foo_controller = new \FooController($this->_request, $this->_response);
        $reflection_method = new \ReflectionMethod($foo_controller, 'barAction');
        /* @var $reflection_parameter \ReflectionParameter */
        $reflection_parameter = current($reflection_method->getParameters());
        $this->assertEquals('var', $reflection_parameter->getName());
    }
}
