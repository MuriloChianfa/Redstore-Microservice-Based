<?php

namespace Source\Controllers;

use Source\Models\User;

class Checkout extends Controller
{
    /** @var mixed */
    private $user;

    public function __construct($router)
    {
        parent::__construct($router);

        if (!isset($_SESSION['user'])) {
            $_SESSION['returnToCart'] = true;

            flash("info", "Entre ou crie uma conta antes!");
            $this->router->redirect("login.login");
        }

        $req = callAPI('/me/profile', 'POST', null, $_SESSION['user']);

        if (isset($req['curl_error'])) {
            error_log(json_encode($req));
            return;
        }

        if ($req['code'] != 200) {
            if ((json_decode($req['result']))->message == 'please login first') {
                $_SESSION['user'] = '';
                return;
            }

            return;
        }
        
        $this->user = (json_decode($req['result']))->message;
    }

    public function selectAddress(): void
    {
        if (empty($this->user)) {
            $_SESSION['returnToCart'] = true;

            flash("info", "Entre ou crie uma conta antes!");
            $this->router->redirect("login.login");
        }

        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('checkout.selectAddress'),
            routeImage('Checkout Address')
        )->render();

        echo $this->view->render('theme/checkout/select-address', [
            'head' => $head,
            'userData' => $this->user,
            'mainURL' => BASE_API 
        ]);
    }

    public function paymentMethod(): void
    {
        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('checkout.selectAddress'),
            routeImage('Checkout Address')
        )->render();

        echo $this->view->render('theme/checkout/pagseguro/payment-method', [
            'head' => $head,
            'userData' => $this->user,
            'mainURL' => BASE_API 
        ]);
    }

    public function boleto(): void
    {
        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('checkout.boleto'),
            routeImage('Checkout boleto')
        )->render();

        echo $this->view->render('theme/checkout/pagseguro/methods/boleto', [
            'head' => $head,
            'userData' => $this->user,
            'mainURL' => BASE_API 
        ]);
    }

    public function credit(): void
    {
        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('checkout.credit'),
            routeImage('Checkout credit')
        )->render();

        echo $this->view->render('theme/checkout/pagseguro/methods/credit', [
            'head' => $head,
            'userData' => $this->user,
            'mainURL' => BASE_API 
        ]);
    }

    public function debit(): void
    {
        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('checkout.debit'),
            routeImage('Checkout debit')
        )->render();

        echo $this->view->render('theme/checkout/pagseguro/methods/debit', [
            'head' => $head,
            'userData' => $this->user,
            'mainURL' => BASE_API 
        ]);
    }

    public function success(): void
    {
        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('checkout.success'),
            routeImage('Checkout success')
        )->render();

        echo $this->view->render('theme/checkout/success', [
            'head' => $head
        ]);
    }
}
