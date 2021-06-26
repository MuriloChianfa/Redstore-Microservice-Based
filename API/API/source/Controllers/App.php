<?php

namespace Source\Controllers;

use \stdClass;

use Source\Core\Request;
use Source\Core\Response;

use Source\Models\Product;
use Source\Models\Category;

class App
{
    private $Message;

    private $Request;

    public function __construct()
    {
        $this->Message = new stdClass();
        $this->Request = new Request();
    }

    public function test()
    {
        $this->Message->message = 'this is a test';
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function error($data)
    {
        $this->Message->message = '404 Not Found';

        (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
    }
}
