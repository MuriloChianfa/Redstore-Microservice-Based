<?php

namespace Source\Controllers;

use \stdClass;

use Source\Core\Request;
use Source\Core\Response;

use Source\Models\User;
use Source\Models\Phone;
use Source\Models\Gender;
use Source\Models\AccessLevel;

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

    public function profile()
    {
        $token = (new Auth())->validateLogin();
        
        $User = new User();
        $result = $User->findById($token['id'], "
            id, 
            gender_id, 
            access_level_id, 
            first_name, 
            last_name, 
            email, 
            cpf, 
            birth_date, 
            photo, 
            status, 
            receive_promotion
        ");
        
        if (!$result || $result == null) {
            $this->Message->message = 'Usuário não encontrado!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        $result = $result->data();

        $this->Message->message = $result;
        $this->Message->message->phone = (new Phone())->findByUserId($result->id);
        $this->Message->message->gender_id = (new Gender())->findById($result->gender_id)->data();
        $this->Message->message->access_level_id = (new AccessLevel())->findById($result->access_level_id)->data();
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
}
