<?php

namespace Merkury;

class Autoloader
{
    private $_include_paths = [];

    public function __construct(array $paths_namespaces = array())
    {
        foreach ($paths_namespaces as $path){
            $path = realpath($path);
            $this->_include_paths[$path] = $path;
        }
    }

    public function autoload($class_name)
    {
        $include_class_name = str_replace('\\', '/', $class_name) . '.php';

        if($include_class = $this->_fileExistsOnIncludePaths($include_class_name))
            require_once $include_class;

    }

    protected function _fileExistsOnIncludePaths($file)
    {
        foreach ($this->_include_paths as $path){
            $include_class = $path . '/' . $file;

            if(file_exists($include_class))
                return $include_class;
        }
    }
}
