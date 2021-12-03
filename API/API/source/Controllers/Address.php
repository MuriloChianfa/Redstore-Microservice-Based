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

final class AddressController
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

        if (empty($data['city_id'])) {
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

        if (empty($data['street'])) {
            $this->Message->message = 'Nome da rua inválida!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        if (empty($data['cep'])) {
            $this->Message->message = 'CEP inválido!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        if (empty($data['number'])) {
            $this->Message->message = 'Número da casa inválido!';
            (new Response())->setStatusCode(HTTP_PARTIAL_CONTENT)->send($this->Message);
            return;
        }

        /** @var Source\Models\Address $Address */
        $Address = new Address();
        $Address->city_id = $data['city_id'];
        $Address->street = $data['street'];
        $Address->cep = $data['cep'];
        $Address->number = $data['number'];

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
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
}
