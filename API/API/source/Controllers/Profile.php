<?php

namespace Source\Controllers;

use \stdClass;

use Source\Core\Request;
use Source\Core\Response;

use Source\Models\User;
use Source\Models\Phone;
use Source\Models\Gender;
use Source\Models\AccessLevel;
use Source\Models\Address\Address;
use Source\Models\Address\City;

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
        
        $result = $User->findById($this->token['id'], 'id, gender_id, access_level_id, first_name, last_name, email, cpf, birth_date, photo, status, receive_promotion');
        
        if (!$result || $result == null) {
            $this->Message->message = 'Usuário não encontrado!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        $result = $result->data();

        $this->Message->message = $result;
        $this->Message->message->phone = (new Phone())->findByUserId($result->id);
        $this->Message->message->address = Address::getAddressByUserId($result->id);
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

        /** @var \Source\Models\User $User */
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

    public function addPhone($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data)) {
            $this->Message->message = 'Campos inválidos!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $User = new User();
        /** @var Source\Models\User $User */
        $User = $User->findById($this->token['id'], 'id');

        if (!$User || $User == null) {
            $this->Message->message = 'Usuário não encontrado!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        if (empty($data['number'])) {
            $this->Message->message = 'Número de telefone inválido!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        /** @var Source\Models\Phone $Phone */
        $Phone = new Phone();
        $Phone->user_id = $User->id;
        $Phone->phone_type_id = 1;
        $Phone->number = $data['number'];

        if (!$Phone->save()) {
            $this->Message->message = $User->message();
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $this->Message->message = 'Alteração realizada com sucesso!';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        return;
    }
    
    public function updatePhone($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data)) {
            $this->Message->message = 'Campos inválidos!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $User = new User();
        $User = $User->findById($this->token['id'], 'id');

        if (!$User || $User == null) {
            $this->Message->message = 'Usuário não encontrado!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        if (!filter_var($data['id'], FILTER_VALIDATE_INT)) {
            $this->Message->message = 'Número de telefone inválido!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $Phone = new Phone();
        /** @var Source\Models\Phone $Phone */
        $Phone = $Phone->findById($data['id'], 'id, user_id');

        if ($User->id != $Phone->user_id) {
            $this->Message->message = 'Você não possui permisão para alterar este telefone!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        if (empty($data['number'])) {
            $this->Message->message = 'Número de telefone inválido!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $Phone->phone_type_id = 1;
        $Phone->number = $data['number'];

        if (!$Phone->save()) {
            $this->Message->message = $Phone->message();
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $this->Message->message = 'Alteração realizada com sucesso!';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        return;
    }
    
    public function addAddress($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data)) {
            $this->Message->message = 'Campos inválidos!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $User = new User();
        /** @var Source\Models\User $User */
        $User = $User->findById($this->token['id'], 'id');

        if (!$User || $User == null) {
            $this->Message->message = 'Usuário não encontrado!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }
        
        $city_id = filter_var($data['city_id'], FILTER_DEFAULT);
        $street = filter_var($data['street'], FILTER_DEFAULT);
        $complement = filter_var($data['complement'], FILTER_DEFAULT);
        $cep = filter_var($data['cep'], FILTER_DEFAULT);
        $number = filter_var($data['number'], FILTER_DEFAULT);

        if (!$city_id) {
            $this->Message->message = 'Cidade inválida!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        if (!$street) {
            $this->Message->message = 'Nome da rua inválida!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        if (!$cep) {
            $this->Message->message = 'CEP inválido!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        if (!$number) {
            $this->Message->message = 'Número da casa inválido!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        /** @var Source\Models\Address $Address */
        $Address = new Address();

        $Address->city_id = $city_id;
        $Address->street = $street;
        $Address->complement = $complement;
        $Address->cep = $cep;
        $Address->number = $number;

        if (!$Address->save()) {
            $this->Message->message = $Address->message();
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        if (!Address::bindAddress($User->id, $Address->id)) {
            $this->Message->message = 'Ocorreu algum erro ao cadastrar o endereço!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $this->Message->message = 'Endereço salvo com sucesso!';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        return;
    }
    
    public function updateAddress($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data) || !isset($data['id']) || !filter_var($data['id'], FILTER_VALIDATE_INT)) {
            $this->Message->message = 'Campos inválidos!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $User = new User();
        $User = $User->findById($this->token['id'], 'id');

        if (!$User || $User == null) {
            $this->Message->message = 'Usuário não encontrado!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        if (!Address::getBindedAddress($User->id, $data['id'])) {
            $this->Message->message = 'Você não possui permissão para editar este endereço!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        if (isset($data['city_id'])) {
            $city_id = filter_var($data['city_id'], FILTER_DEFAULT);
    
            if (!$city_id) {
                $this->Message->message = 'Cidade inválida!';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }

            $City = new City();

            if (!$City->findById($data['city_id'])) {
                $this->Message->message = 'Cidade inválida!';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }
        }

        if (isset($data['street'])) {
            $street = filter_var($data['street'], FILTER_DEFAULT);
    
            if (!$street) {
                $this->Message->message = 'Nome da rua inválida!';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }
        }

        if (isset($data['cep'])) {
            $cep = filter_var($data['cep'], FILTER_DEFAULT);
    
            if (!$cep) {
                $this->Message->message = 'CEP inválido!';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }
        }

        if (isset($data['number'])) {
            $number = filter_var($data['number'], FILTER_DEFAULT);
    
            if (!$number) {
                $this->Message->message = 'Número da casa inválido!';
                (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
                return;
            }
        }

        /** @var Source\Models\Address $Address */
        $Address = new Address();

        if (isset($data['city_id'])) {
            $Address->city_id = $city_id;
        }

        if (isset($data['street'])) {
            $Address->street = $street;
        }

        if (isset($data['cep'])) {
            $Address->cep = $cep;
        }

        if (isset($data['number'])) {
            $Address->number = $number;
        }

        if (!$Address->save()) {
            $this->Message->message = $Address->message();
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        $this->Message->message = 'Endereço salvo com sucesso!';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        return;
    }

    public function address($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data) || !isset($data['id']) || !filter_var($data['id'], FILTER_VALIDATE_INT)) {
            $this->Message->message = 'Campos inválidos!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        /** @var Source\Models\Address $Address */
        $Address = new Address();
        $result = $Address->findById($data['id'], "*");
        
        if (!$result || $result == null) {
            $this->Message->message = 'Endereço não encontrado!';
            (new Response())->setStatusCode(HTTP_NOT_FOUND)->send($this->Message);
            return;
        }

        $result = $result->data();

        $this->Message->message = $result;
        // $this->Message->message->city_id = $result->city_id;
        // $this->Message->message->street = $result->street;
        // $this->Message->message->number = $result->number;
        // $this->Message->message->complement = $result->complement;
        // $this->Message->message->cep = $result->cep;
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
}

