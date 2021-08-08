<?php

namespace Source\Controllers;

use Source\Support\Email;

class Auth extends Controller
{
    public function __construct($router) {
        parent::__construct($router);
    }

    public function login($data): void {
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $passwd = filter_var($data['password'], FILTER_DEFAULT);

        if(!$email || !$passwd) {
            echo $this->ajaxResponse('message', [
                'type' => 'alert',
                'message' => 'Informe seu e-mail e senha para logar'
            ]);
            return;
        }

        $data = [
            'email' => $email,
            'password' => $passwd
        ];

        $req = callAPI('/login', 'POST', $data);

        if (isset($req['curl_error']) || $req['code'] != 200) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => 'Ocorreu algum problema interno!'
            ]);
            return;
        }

        $req = json_decode($req['result']);

        if (!isset($req->token)) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => $req->message
            ]);
            return;
        }

        $_SESSION['user'] = $req->token;

        if (!empty($_SESSION['returnToCart'])) {
            unset($_SESSION['returnToCart']);
            echo $this->ajaxResponse('redirect', [
                'url' => $this->router->route('checkout.selectAddress')
            ]);
            return;
        }

        echo $this->ajaxResponse('redirect', [
            'url' => $this->router->route('app.account')
        ]);
    }

    public function register($data): void {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if(in_array('', $data) || empty($data)) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => 'Preencha todos os campos para cadastrar-se'
            ]);
            return;
        }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => 'Favor informe um e-mail válido para continuar'
            ]);
            return;
        }

        $req = callAPI('/register', 'POST', $data);

        if (isset($req['curl_error']) || $req['code'] != 200) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => 'Ocorreu algum problema interno!'
            ]);
            return;
        }

        $req = json_decode($req['result']);

        if (!isset($req->token)) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => $req->message
            ]);
            return;
        }

        $_SESSION['user'] = $req->token;

        echo $this->ajaxResponse('redirect', [
            'url' => $this->router->route('app.account')
        ]);
    }

    public function forget($data): void {
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        if(!$email) {
            echo $this->ajaxResponse('message', [
                'type' => 'alert',
                'message' => 'Informe um e-mail valido para continuar'
            ]);
            return;
        }

        $user = (new User())->find('email = :e', "e={$email}")->fetch();
        if(!$user) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => 'E-mail informado, não cadastrado'
            ]);
            return;
        }

        $user->forget = (md5(uniqid(rand(), true)));
        $user->save();

        $_SESSION['forget'] = $user->id;

        $email = new Email();
        $email->add(
            'Recupere sua senha |'. site('name'),
            $this->view->render('emails/recover', [
                'user' => $user,
                'link' => $this->router->route('web.reset', [
                    'email' => $user->email,
                    'forget' => $user->forget
                ])
            ]),
            "{$user->first_name} {$user->last_name}",
            $user->email
        )->send();

        flash('success', 'Enviamos um link de recuperação para seu e-mail');

        echo $this->ajaxResponse('redirect', [
            'url' => $this->router->route('web.forget')
        ]);
    }

    public function reset($data): void {
        if(empty($_SESSION['forget']) || !$user = (new User())->findById($_SESSION['forget'])) {
            flash('error', 'Não foi possivel recuperar');
            echo $this->ajaxResponse('redirect', [
                'url' => $this->router->route('web.forget')
            ]);
            return;
        }

        if(empty($data['password']) || empty($data['password_re'])) {
            echo $this->ajaxResponse('message', [
                'type' => 'alert',
                'message' => 'Informe e repita sua nova senha'
            ]);
        }

        if($data['password'] != $data['password_re']) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => 'As senhas nao batem'
            ]);
        }

        $user->passwd = $data['password'];
        $user->forget = null;

        if(!$user->save()) {
            echo $this->ajaxResponse('message', [
                'type' => 'error',
                'message' => $user->fail()->getMessage()
            ]);
            return;
        }

        unset($_SESSION['forget']);

        flash('success', 'Sua senha foi atualizada com sucesso');
        echo $this->ajaxResponse('redirect', [
            'url' => $this->router->route('web.login')
        ]);
    }
}


