<?php

namespace Source\Controllers;

use Source\Models\User;

class Web extends Controller {
    public function __construct($router) {
        parent::__construct($router);
    }

    public function home(): void {
        $head = $this->seo->optimize(
            "RedStore | " . site("name"),
            site("desc"),
            $this->router->route("web.home"),
            routeImage("Home")
        )->render();

        echo $this->view->render("theme/main/index", [
            "head" => $head
        ]);
    }

    public function products(): void {
        $head = $this->seo->optimize(
            "RedStore | " . site("name"),
            site("desc"),
            $this->router->route("web.products"),
            routeImage("Products")
        )->render();

        echo $this->view->render("theme/main/products", [
            "head" => $head
        ]);
    }

    public function productsDetails(): void {
        $head = $this->seo->optimize(
            "RedStore | " . site("name"),
            site("desc"),
            $this->router->route("web.productsDetails"),
            routeImage("ProductsDetails")
        )->render();

        echo $this->view->render("theme/main/products-details", [
            "head" => $head
        ]);
    }

    public function about(): void {
        $head = $this->seo->optimize(
            "RedStore | " . site("name"),
            site("desc"),
            $this->router->route("web.about"),
            routeImage("About")
        )->render();

        echo $this->view->render("theme/main/about", [
            "head" => $head
        ]);
    }

    public function cart(): void {
        $head = $this->seo->optimize(
            "RedStore | " . site("name"),
            site("desc"),
            $this->router->route("web.cart"),
            routeImage("Cart")
        )->render();

        echo $this->view->render("theme/main/cart", [
            "head" => $head
        ]);
    }

    public function error($data): void {
        $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);
        $head = $this->seo->optimize(
            "Ooooppss {$error} |" . site("name"),
            site("desc"),
            $this->router->route("web.error", ["errcode" => $error]),
            routeImage($error)
        )->render();

        echo $this->view->render("theme/main/index", [
            "head" => $head,
            "error" => $error
        ]);
    }
}