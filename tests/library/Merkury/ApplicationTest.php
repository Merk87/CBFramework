<?php


namespace Merkury;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInstaceApplication()
    {
        $this->assertInstanceOf('Merkury\Application', new Application());
    }
}
