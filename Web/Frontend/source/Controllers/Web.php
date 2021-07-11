<?php

namespace Source\Controllers;

use Source\Models\User;

class Web extends Controller
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

    public function home(): void
    {
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

    public function products(): void
    {
        $head = $this->seo->optimize(
            "RedStore | " . site("name"),
            site("desc"),
            $this->router->route("web.products"),
            routeImage("Products")
        )->render();

        echo $this->view->render("theme/products/products", [
            "head" => $head,
            'user' => $this->user
        ]);
    }

    public function productsDetails(): void
    {
        $head = $this->seo->optimize(
            "RedStore | " . site("name"),
            site("desc"),
            $this->router->route("web.productsDetails"),
            routeImage("ProductsDetails")
        )->render();

        echo $this->view->render("theme/products/products-details", [
            "head" => $head
        ]);
    }

    public function productInsert(): void
    {
        if (empty($this->user) || !in_array($this->user->access_level_id->name, [ 'Administrador', 'Gerente', 'Vendedor' ])) {
            $this->router->redirect("web.products");
        }

        $head = $this->seo->optimize(
            "RedStore | " . site("name"),
            site("desc"),
            $this->router->route("web.productInsert"),
            routeImage("ProductInsert")
        )->render();

        $req = callAPI('/categories', 'GET');

        if (isset($req['curl_error']) || $req['code'] != 200) {
            error_log(json_encode($req));
            $this->router->redirect("web.products");
        }

        $categories = (json_decode($req['result']))->message;

        echo $this->view->render("theme/products/product-insert", [
            "head" => $head,
            'categories' => $categories,
            'mainURL' => BASE_API
        ]);
    }

    public function about(): void
    {
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

    public function cart(): void
    {
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

    public function error($data): void
    {
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
