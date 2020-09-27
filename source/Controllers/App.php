<?php

namespace Source\Controllers;

use Source\Models\User;

class App extends Controller {

    /** @var User */
    protected $user;

    public function __construct($router) {
        parent::__construct($router);

        if(empty($_SESSION["user"]) || !$this->user = (new User())->findById($_SESSION["user"])) {
            unset($_SESSION["user"]);

            flash("error", "Acesso negado. Favor logar antes");
            $this->router->redirect("web.login");
        }

        //
    }

    public function home(): void {
        // var_dump($this->user);
        $head = $this->seo->optimize(
            "Bem vindo(a) {$this->user->first_name} |" . site("name"),
            site("desc"),
            $this->router->route("app.home"),
            routeImage("Conta de {$this->user->first_name}")
        )->render();

        echo $this->view->render("theme/dashboard", [
            "head" => $head,
            "user" => $this->user
        ]);
    }

    public function logoff(): void {
        unset($_SESSION["user"]);

        flash("info", "Você saiu com sucesso, volte logo {$this->user->first_name}");
        $this->router->redirect("web.login");
    }
}

