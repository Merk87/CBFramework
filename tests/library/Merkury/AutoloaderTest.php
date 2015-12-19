<?php


namespace Merkury;

class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var type 
     */
    protected $_autoloader;

    protected function setUp() {
        spl_autoload_unregister(array($GLOBALS['autoloader'], 'autoload'));
        $this->_autoloader = new Autoloader(array(
                APP_PATH . '/../tests/library/Merkury/src'
       ));

        spl_autoload_register(array($this->_autoloader, 'autoload'));
        parent::setUp();
    }
    public function testClassThatExists()
    {
        $this->assertInstanceOf('Test\DummyClass', new \Test\DummyClass());
    }

    protected function tearDown() {
        spl_autoload_unregister(array($this->_autoloader, 'autoload'));
        spl_autoload_register(array($GLOBALS['autoloader'], 'autoload'));
        parent::tearDown();
    }
}
