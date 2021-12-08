<?php

namespace Source\Controllers;

class App extends Controller
{
    /** @var mixed */
    protected $user;

    public function __construct($router)
    {
        parent::__construct($router);

        if (empty(@$_SESSION["user"])) {
            flash("error", "Acesso negado. Favor logar antes");
            $this->router->redirect("login.login");
        }

        $this->user = $_SESSION["user"];
    }

    public function account(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo(a) a |" . site("name"),
            site("desc"),
            $this->router->route("app.account"),
            routeImage("Conta de ")
        )->render();

        $req = callAPI('/me/profile', 'POST', null, $this->user);

        if (isset($req['curl_error']) || $req['code'] != 200) {
            $userData = $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Ocorreu algum problema interno!"
            ]);
        }

        $userData = (json_decode($req['result']))->message;

        echo $this->view->render("theme/account/account", [
            "head" => $head,
            "userData" => $userData,
            'userJWT' => $this->user,
            'mainURL' => BASE_API
        ]);
    }

    public function logoff(): void
    {
        unset($_SESSION["user"]);

        flash("info", "Você saiu com sucesso, volte logo");
        $this->router->redirect("login.login");
    }
}
