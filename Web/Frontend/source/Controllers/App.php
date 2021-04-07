<?php

namespace Source\Controllers;

use Source\Models\User;

class App extends Controller {

    /** @var User */
    protected $user;

    public function __construct($router) {
        parent::__construct($router);

        // if(empty(@$_SESSION["user"])) {
        //     unset(@$_SESSION["user"]);

        //     flash("error", "Acesso negado. Favor logar antes");
        //     $this->router->redirect("web.login");
        // }

        //
    }

    public function account(): void {
        // var_dump($this->user);
        $head = $this->seo->optimize(
            "Bem vindo(a) a |" . site("name"),
            site("desc"),
            $this->router->route("app.account"),
            routeImage("Conta de a")
        )->render();

        echo $this->view->render("theme/account/account", [
            "head" => $head,
            "user" => $this->user
        ]);
    }

    public function logoff(): void {
        unset($_SESSION["user"]);

        flash("info", "Você saiu com sucesso, volte logo a");
        $this->router->redirect("web.login");
    }
}

