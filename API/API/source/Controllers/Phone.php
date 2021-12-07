<?php

namespace Source\Controllers;

use stdClass;
use Source\Core\Request;
use Source\Core\Response;
use Source\Models\User;
use Source\Models\Phone;
use Source\Models\Gender;
use Source\Models\AccessLevel;
use Source\Models\Address\Address;
use Source\Models\Address\City;
use Source\Controllers\Auth;

final class PhoneController
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
}
