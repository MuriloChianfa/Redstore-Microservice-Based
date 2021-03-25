<?php

namespace Source\Controllers;

use Source\Models\User;

class Login extends Controller {
    public function __construct($router) {
        parent::__construct($router);
        // if(!empty($_SESSION["user"])) {
        //     $this->router->redirect("web.home");
        // }
    }

    public function loginn(): void {
        $head = $this->seo->optimize(
            "Faça login para continuar |" . site("name"),
            site("desc"),
            $this->router->route("login.login"),
            routeImage("Login")
        )->render();

        echo $this->view->render("theme/main/login", [
            "head" => $head
        ]);
    }

    public function register(): void {
        $head = $this->seo->optimize(
            "Crie sua conta no " . site("name"),
            site("desc"),
            $this->router->route("web.register"),
            routeImage("Register")
        )->render();

        $form_user = new \stdClass();
        $form_user->first_name = null;
        $form_user->last_name = null;
        $form_user->email = null;

        echo $this->view->render("theme/register", [
            "head" => $head,
            "user" => $form_user
        ]);
    }

    public function forget(): void {
        $head = $this->seo->optimize(
            "Recupere sua senha |" . site("name"),
            site("desc"),
            $this->router->route("web.forget"),
            routeImage("Forget")
        )->render();

        echo $this->view->render("theme/forget", [
            "head" => $head
        ]);
    }

    public function reset($data): void {
        if(empty($_SESSION["forget"])) {
            flash("info", "Informe seu email para recuperar a senha");
            $this->router->redirect("web.forget");
        }

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $forget = filter_var($data["forget"], FILTER_DEFAULT);

        $errForget = "Não foi possivel continuar com a verificação";

        if(!$email || !$forget) {
            flash("error", $errForget);
            $this->router->redirect("web.forget");
        }

        $user = (new User())->find("email = :e AND forget = :f", "e={$email}&f={$forget}")->fetch();
        if(!$user) {
            flash("error", $errForget);
            $this->router->redirect("web.forget");
        }

        $head = $this->seo->optimize(
            "Crie sua nova senha |" . site("name"),
            site("desc"),
            $this->router->route("web.reset"),
            routeImage("Reset")
        )->render();

        echo $this->view->render("theme/reset", [
            "head" => $head
        ]);
    }
}