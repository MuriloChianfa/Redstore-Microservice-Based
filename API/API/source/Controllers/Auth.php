<?php

namespace Source\Controllers;

use \stdClass;

use Source\Core\Request;
use Source\Core\Response;
use Source\Core\Token;
use Source\Core\Redis;

use Source\Models\User;

use Source\Core\Rabbit\RabbitSender;

class Auth
{
    private $Message;

    private $Request;

    public function __construct()
    {
        $this->Message = new stdClass();
        $this->Request = new Request();
    }

    public function login($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $passwd = filter_var($data["password"], FILTER_DEFAULT);

        if(!$email || !$passwd) {
            $this->Message->message = 'Informe seu e-mail e senha para logar';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $User = new User();

        $result = $User->findByEmail($email);

        if (!$result || $result == null) {
            $this->Message->message = 'E-mail ou senha inválido';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        if (!password_verify($passwd, $result->password)) {
            $this->Message->message = 'E-mail ou senha inválido';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $jwt = new stdClass();
        $jwt->id = $result->id;
        $jwt->email = $result->email;

        $this->Message->message = 'login successful';
        $this->Message->token = (new Token())->generateNewToken($jwt);

        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function register($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $passwd = filter_var($data["password"], FILTER_DEFAULT);
        $first_name = filter_var($data["first_name"], FILTER_DEFAULT);
        $last_name = filter_var($data["last_name"], FILTER_DEFAULT);

        if(!$email || !$passwd) {
            $this->Message->message = 'Informe um e-mail e uma senha para se cadastrar!';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        if(!$first_name) {
            $this->Message->message = 'Informe seu primeiro nome para se cadastrar!';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        if(!$last_name) {
            $this->Message->message = 'Informe seu ultimo nome para se cadastrar!';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $User = new User();

        $User->first_name = $first_name;
        $User->last_name = $last_name;
        $User->email = $email;
        $User->password = $passwd;

        if (!$User->save()) {
            $this->Message->message = $User->message();
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $result = $User->data();
        
        $jwt = new stdClass();
        $jwt->id = $result->id;
        $jwt->email = $result->email;

        $this->Message->message = 'registered with success';
        $this->Message->token = (new Token())->generateNewToken($jwt);

        (new RabbitSender('email', 'email'))->sendMessage(json_encode([
            'type' => 'confirmEmail',
            'content' => [
                'email' => $result->email
            ]
        ]));

        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function forget($data)
    {
        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);

        if(!$email) {
            $this->Message->message = 'Informe um e-mail valido para continuar';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $User = new User();

        if (($User = $User->findByEmail($email))) {
            $forget = (md5(uniqid(rand(), true)));

            $User->forget = $forget;
            $User->save();

            /*********************** ************************/
            // fazer um push para o rabbit na fila de email //
            /*********************** ************************/

            (new RabbitSender('email', 'email'))->sendMessage(json_encode([
                'type' => 'resetPassword',
                'content' => [
                    'email' => $email,
                    'forget' => $forget
                ]
            ]));

            $this->Message->message = 'Enviamos um link de recuperação para seu e-mail';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $User = new User();
        $User->forget = (md5(uniqid(rand(), true)));
        
        $this->Message->message = 'Enviamos um link de recuperação para seu e-mail';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function reset($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $forget = filter_var($data["forget"], FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[a-f0-9]{32}$/"]]);

        if (!$email || !$forget) {
            $this->Message->message = 'Entrada inválida';
            (new Response())->setStatusCode(HTTP_UNAUTHORIZED)->send($this->Message);
            return;
        }

        $User = new User();

        $result = $User->find("email = :e AND forget = :f", "e={$email}&f={$forget}", "id")->fetch();

        if (!$result || $result == null) {
            $this->Message->message = 'Entrada inválida';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $passwd = filter_var($data["password"], FILTER_DEFAULT);
        $passwdRepeat = filter_var($data["passwordRepeat"], FILTER_DEFAULT);

        if(!$passwd || !$passwdRepeat) {
            $this->Message->message = 'Informe e repita sua nova senha!';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        if($passwd != $passwdRepeat) {
            $this->Message->message = 'As senhas nao batem!';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $result = $result->data();

        $User = new User();
        $User = $User->findById($result->id);

        $User->forget = null;
        $User->password = $passwd;

        if (!$User->save()) {
            $this->Message->message = $User->message();
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $jwt = new stdClass();
        $jwt->id = $User->id;
        $jwt->email = $User->email;

        $this->Message->message = 'password altered with success';
        $this->Message->token = (new Token())->generateNewToken($jwt);

        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function logoff()
    {
        $token = (object) $this->validateLogin();

        $Redis = (new Redis())->getClient();

        if ($Redis->del($token->id.$token->expirationTime) === 0) {
            $this->Message->message = 'Ocorreu algum erro!';
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $this->Message->message = 'Você saiu com sucesso volte logo =)';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
    
    public function validateLogin()
    {
        if (!($jwt = $this->Request->getToken())) {
            $this->Message->message = $this->Request->getError();
            (new Response())->setStatusCode(HTTP_UNAUTHORIZED)->send($this->Message);
            exit;
        }

        $validToken = ($Token = new Token())->validateToken($jwt);

        if (!$validToken) {
            $this->Message->message = $Token->getError();
            (new Response())->setStatusCode(HTTP_UNAUTHORIZED)->send($this->Message);
            exit;
        }

        return $Token->getToken();
    }
}
