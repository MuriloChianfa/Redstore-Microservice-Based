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
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('web.home'),
            routeImage('Home')
        )->render();

        $req = callAPI('/products/1/4/rate/DESC', 'GET', [], $_SESSION['user'] ?? '');
        $req2 = callAPI('/products/1/4/id/DESC', 'GET', [], $_SESSION['user'] ?? '');
        $req3 = callAPI('/products/2/4/id/DESC', 'GET', [], $_SESSION['user'] ?? '');

        $featuredProducts = (json_decode($req['result']))->message ?? [];
        $latestProducts = (json_decode($req2['result']))->message ?? [];
        $latestProducts2 = (json_decode($req3['result']))->message ?? [];

        echo $this->view->render('theme/main/index', [
            'head' => $head,
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
            'latestProducts2' => $latestProducts2
        ]);
    }

    public function products($data): void
    {
        $page = 1;
        $sort = 'id';

        if (!empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            if (isset($data['page'])) {
                if (filter_var($data['page'], FILTER_VALIDATE_INT)) {
                    $page = $data['page'];
                }
            }

            if (isset($data['sort'])) {
                switch ($data['sort']) {
                    case 'value': $sort = 'value'; break;
                    case 'rate': $sort = 'rate'; break;
                    case 'views': $sort = 'rate'; break;
                    case 'sales': $sort = 'id'; break;
                    default: $sort = 'id'; break;
                }
            }
        }

        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('web.products'),
            routeImage('Products')
        )->render();

        $req = callAPI("/products/{$page}/12/{$sort}/DESC", 'GET', [], $_SESSION['user'] ?? '');
        if (isset($req['curl_error']) || $req['code'] != 200) { error_log(json_encode($req)); }

        $products = (json_decode($req['result']))->message ?? [];
        $productsCount = (json_decode($req['result']))->count ?? 0;

        $lastpage = ceil($productsCount / 12);
        if ($lastpage == 0) { $lastpage = 1; }

        echo $this->view->render('theme/products/products', [
            'head' => $head,
            'user' => $this->user,
            'currentPage' => $page,
            'sort' => $sort,
            'lastPage' => $lastpage,
            'products' => $products,
            'productsCount' => $productsCount
        ]);
    }

    public function productsDetails($data): void
    {
        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('web.productsDetails'),
            routeImage('ProductsDetails')
        )->render();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (!isset($data['id']) || !filter_var($data['id'], FILTER_VALIDATE_INT)) {
            $this->router->redirect('web.home');
        }

        $req = callAPI("/product/{$data['id']}", 'GET', [], $_SESSION['user'] ?? '');
        if (isset($req['curl_error']) || $req['code'] != 200) { error_log(json_encode($req)); }

        $product = (json_decode($req['result']))->message;

        $req = callAPI("/products/1/4/rate/DESC/product_type_id/{$product->category->id}/{$product->id}", 'GET', [], $_SESSION['user'] ?? '');
        if (isset($req['curl_error']) || $req['code'] != 200) { error_log(json_encode($req)); }

        $relatedProducts = (json_decode($req['result']))->message ?? [];

        echo $this->view->render('theme/products/products-details', [
            'head' => $head,
            'user' => $this->user,
            'token' => $_SESSION['user'] ?? '',
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function productInsert(): void
    {
        if (empty($this->user) || !in_array($this->user->access_level_id->name, [ 'Administrador', 'Gerente', 'Vendedor' ])) {
            $this->router->redirect('web.products');
        }

        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('web.productInsert'),
            routeImage('ProductInsert')
        )->render();

        $req = callAPI('/categories', 'GET');

        if (isset($req['curl_error']) || $req['code'] != 200) {
            error_log(json_encode($req));
            $this->router->redirect('web.products');
        }

        $categories = (json_decode($req['result']))->message;

        echo $this->view->render('theme/products/product-insert', [
            'head' => $head,
            'categories' => $categories,
            'mainURL' => BASE_API
        ]);
    }

    public function about(): void
    {
        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('web.about'),
            routeImage('About')
        )->render();

        echo $this->view->render('theme/main/about', [
            'head' => $head
        ]);
    }

    public function cart(): void
    {
        $head = $this->seo->optimize(
            'RedStore | ' . site('name'),
            site('desc'),
            $this->router->route('web.cart'),
            routeImage('Cart')
        )->render();

        echo $this->view->render('theme/main/cart', [
            'head' => $head
        ]);
    }

    public function error($data): void
    {
        $error = filter_var($data['errcode'], FILTER_VALIDATE_INT);

        $head = $this->seo->optimize(
            "Ooooppss {$error} |" . site('name'),
            site('desc'),
            $this->router->route('web.error', [ 'errcode' => $error ]),
            routeImage($error)
        )->render();

        echo $this->view->render('theme/main/error', [
            'head' => $head,
            'error' => $error
        ]);
    }
}
