<?php

namespace Source\Controllers;

use \stdClass;

use Source\Core\Request;
use Source\Core\Response;

use Source\Controllers\Auth;

class Profile
{
    private $Message;

    private $Request;

    public function __construct()
    {
        $this->Message = new stdClass();
        $this->Request = new Request();
    }

    public function cart()
    {
        $token = (new Auth())->validateLogin();
        
        $this->Message->message = $token;
        // $this->Message->message = 'this is your cart';
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
}
