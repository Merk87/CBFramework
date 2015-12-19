<?php

namespace Merkury\Url;

class UriTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInstanceUriClass()
    {
        $uri = new Uri('test', 'test', 'test');
        
        $this->assertInstanceOf('Merkury\Url\Uri', $uri);
    }
    
    public function testMatchCorrectUri()
    {
        $uri = new Uri('test', 'test', 'test');
        $this->assertTrue($uri->match('test'));
    }
    
    public function testMatchUriWithStartSlash()
    {
        $uri = new Uri('test', 'test', 'test');
        $this->assertTrue($uri->match('/test'));
    }
    
    public function testMatchUriWithVariableParameters()
    {
        $uri = new Uri('test/{var}', 'test', 'test');
        $this->assertTrue($uri->match('/test/variable'));
        $this->assertTrue($uri->match('/test/distinct'));
    }
    
    public function testMatchUriWithRestrictedVariableParameters()
    {
        $uri = new Uri('test/{var}', 'test', 'test');
        $uri->where('var', '[0-9]+');
        $this->assertFalse($uri->match('test/test'));
        $this->assertTrue($uri->match('test/1'));
    }
    
    public function testMatchUriCanRetriveElementsMatched()
    {
        $uri = new Uri('test/{var1}/{var2}', 'test', 'test');
        $uri->where('var1', '[a-zA-Z]+');
        $uri->where('var2', '[0-9]+');
        $uri->match('test/Merkury/1234');
        $matches = $uri->getMatches();
        $this->assertTrue($matches['var1'] == 'Merkury');
        $this->assertTrue($matches['var2'] == 1234);
        $this->assertTrue($uri->getControllerName() === 'test');
        $this->assertTrue($uri->getActionName() === 'test');
    }
    public function testMatchUriWithQueryString()
    {
        $uri = new Uri('test', 'test', 'test');
        $this->assertTrue($uri->match('/test/?param=param'));
    }
    public function testLongerUriThatMatchPartiallyMustFail()
    {
         $uri = new Uri('test', 'test', 'test');
         $this->assertFalse($uri->match('/test/blabla'));
    }
}
