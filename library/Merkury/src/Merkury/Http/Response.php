<?php

namespace Merkury\Http;

class Response
{
    private $_header = array();
    private $_body = '';

    public function setHeader($header)
    {
        $this->_header[] = $header;
    }

    public function setBody($body)
    {
        $this->_body = $body;
    }
    public function send()
    {
        foreach ($this->_header as $header){
            header($header);
        }
        echo $this->_body;
    }
}
