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

    private $token;

    public function __construct()
    {
        $this->Message = new stdClass();
        $this->Request = new Request();

        $this->token = (new Auth())->validateLogin();
    }

    public function cart()
    {
        $this->Message->message = $this->token;
        // $this->Message->message = 'this is your cart';
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function profile()
    {
        $User = new User();
        
        $result = $User->findById($this->token['id'], "
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

    public function update($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data)) {
            $this->Message->message = 'Campos inválidos!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        if (isset($data['first_name'])) {
            $first_name = filter_var($data["first_name"], FILTER_DEFAULT);
            
            if(!$first_name) {
                $this->Message->message = 'Nome inválido';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }
        }

        if (isset($data['last_name'])) {
            $last_name = filter_var($data["last_name"], FILTER_DEFAULT);

            if(!$last_name) {
                $this->Message->message = 'Nome inválido';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }
        }

        if (isset($data['birth_date'])) {
            $birth_date = filter_var($data["birth_date"], FILTER_DEFAULT);

            if(!$birth_date) {
                $this->Message->message = 'Data de nascimento inválida';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }
        }

        if (isset($data['cpf'])) {
            $cpf = filter_var($data["cpf"], FILTER_DEFAULT);

            if (!$cpf) {
                $this->Message->message = 'CPF inválido';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }
        }

        $User = new User();

        $User = $User->findById($this->token['id'], 'id');

        if (!$User || $User == null) {
            $this->Message->message = 'Usuário não encontrado!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        if (isset($first_name)) {
            $User->first_name = $first_name;
        }

        if (isset($last_name)) {
            $User->last_name = $last_name;
        }

        if (isset($birth_date)) {
            $User->birth_date = $birth_date;
        }

        if (isset($cpf)) {
            $User->cpf = $cpf;
        }

        if (!$User->updateUser()) {
            $this->Message->message = $User->message();
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $this->Message->message = 'Alteração realizada com sucesso';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        return;
    }
}

