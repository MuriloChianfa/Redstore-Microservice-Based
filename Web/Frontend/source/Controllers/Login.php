<?php

namespace Source\Controllers;

use Source\Models\User;

class Login extends Controller {
    public function __construct($router) {
        parent::__construct($router);
        
        if(!empty($_SESSION["user"])) {
            $this->router->redirect("app.account");
        }
    }

    public function loginn(): void {
        $head = $this->seo->optimize(
            "Faça login para continuar |" . site("name"),
            site("desc"),
            $this->router->route("login.login"),
            routeImage("Login")
        )->render();

        echo $this->view->render("theme/account/login", [
            "head" => $head
        ]);
    }

    public function register(): void {
        $head = $this->seo->optimize(
            "Crie sua conta no " . site("name"),
            site("desc"),
            $this->router->route("login.register"),
            routeImage("Register")
        )->render();

        echo $this->view->render("theme/account/register", [
            "head" => $head
        ]);
    }

    public function forget(): void {
        $head = $this->seo->optimize(
            "Recupere sua senha |" . site("name"),
            site("desc"),
            $this->router->route("login.forget"),
            routeImage("Forget")
        )->render();

        echo $this->view->render("theme/account/forget", [
            "head" => $head
        ]);
    }

    // public function reset($data): void {
    //     if(empty($_SESSION["forget"])) {
    //         flash("info", "Informe seu email para recuperar a senha");
    //         $this->router->redirect("web.forget");
    //     }

    //     $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
    //     $forget = filter_var($data["forget"], FILTER_DEFAULT);

    //     $errForget = "Não foi possivel continuar com a verificação";

    //     if(!$email || !$forget) {
    //         flash("error", $errForget);
    //         $this->router->redirect("web.forget");
    //     }

    //     $user = (new User())->find("email = :e AND forget = :f", "e={$email}&f={$forget}")->fetch();
    //     if(!$user) {
    //         flash("error", $errForget);
    //         $this->router->redirect("web.forget");
    //     }

    //     $head = $this->seo->optimize(
    //         "Crie sua nova senha |" . site("name"),
    //         site("desc"),
    //         $this->router->route("web.reset"),
    //         routeImage("Reset")
    //     )->render();

    //     echo $this->view->render("theme/account/reset", [
    //         "head" => $head
    //     ]);
    // }
}