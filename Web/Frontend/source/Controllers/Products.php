<?php

namespace Source\Controllers;

class Products extends Controller
{
    /** @var mixed */
    private $user;

    public function __construct($router)
    {
        parent::__construct($router);

        if (!isset($_SESSION['user'])) {
            return;
        }

        if (!empty($_SESSION['user'])) {
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
    }

    public function insert($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (in_array('', $data) || empty($data)) {
            $this->send([
                'message' => [
                    'type' => 'error',
                    'message' => 'Preencha todos os campos para cadastrar este novo produto'
                ]
            ]);
        }

        $req = callAPI('/product', 'POST', $data, $_SESSION['user']);

        if (isset($req['curl_error'])) {
            error_log(json_encode($req));
            $this->send([
                'message' => [
                    'type' => 'error',
                    'message' => 'Ocorreu algum erro interno ao cadastrar este produto!'
                ]
            ]);
        }

        if ($req['code'] != 200) {
            error_log(json_encode($req));

            $this->send([
                'message' => [
                    'type' => 'error',
                    'message' => $message = (json_decode($req['result']))->message
                ]
            ]);
        }

        $message = (json_decode($req['result']))->message;

        $this->send([
            'message' => [
                'type' => 'success',
                'message' => $message
            ]
        ]);
    }
}
