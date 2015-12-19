<?php


class FooController extends \Merkury\Controller
{
    public function barAction($var)
    {
        return 'test'.$var;
    }
}
