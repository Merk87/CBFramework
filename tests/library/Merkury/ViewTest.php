<?php

namespace Merkury;

class ViewTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        View::setBasePath(__DIR__ . '/testviews');
        parent::setUp();
    }
    public function testViewCanRenderSimpleTemplate()
    {
        $this->assertEquals('test', View::render('simpletemplate.html'));
    }
    public function testViewCanRenderTemplateExtendingLayout()
    {
        $this->assertEquals('begintestend', View::render('test.html'));
    }
    public function testViewCanRenderVar()
    {
        View::set('varname','varname');
        $this->assertEquals('varname', View::render('testvar.html'));
        $this->assertEquals('varname', View::render('getvar.html'));
        $this->assertEquals('string(7) "varname"', trim(View::render('dumpvar.html')));
    }
    public function testViewMultiInherit()
    {
        $this->assertEquals('12321', View::render('three.html'));
    }
    public function testViewPartial()
    {
         $this->assertEquals('beginpartialend', View::render('viewpartial.html'));
    }
}
