<?php

namespace Source\Controllers;

use \stdClass;

use Source\Core\Request;
use Source\Core\Response;

use Source\Models\Product;
use Source\Models\ProductImage;
use Source\Models\Category;

class Products
{
    /**
     * @var \stdClass $Message
     */
    private $Message;

    /**
     * @var Request $Request
     */
    private $Request;

    /**
     * Products model constructor...
     */
    public function __construct()
    {
        $this->Message = new stdClass();
        $this->Request = new Request();
    }

    /**
     * GET the list of all products
     * 
     * @param array|null $data Receive the current page and limit of then
     * @return void
     */
    public function products($data): void
    {
        $Product = new Product();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data)) {
            if (is_null(($products = $Product->findAll()))) {
                (new Response())->setStatusCode(HTTP_NO_CONTENT)->send($this->Message);
            }

            $this->Message->message = $products;
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        }

        if (!isset($data['page']) || !isset($data['limit'])) {
            $this->Message->message = [
                'message' => 'Missing page or limit argument'
            ];

            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $page = filter_var($data["page"], FILTER_VALIDATE_INT);
        $limit = filter_var($data["limit"], FILTER_VALIDATE_INT);

        if (is_null(($products = $Product->findAll($limit, ($page * $limit) - $limit)))) {
            (new Response())->setStatusCode(HTTP_NO_CONTENT)->send($this->Message);
        }
        
        $this->Message->message = $products;
        $this->Message->count = $Product->coluntAllAvailableProducts();

        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    /**
     * GET one single product
     * 
     * @param array $data
     * @return void
     */
    public function product($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $id = filter_var(@$data["id"], FILTER_VALIDATE_INT);

        if (!$id) {
            $this->Message->message = 'parâmetro inválido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $Product = new Product();

        if (is_null(($product = $Product->findByProductId($id)))) {
            (new Response())->setStatusCode(HTTP_NO_CONTENT)->send($this->Message);
        }

        $this->Message->message = $product->data();

        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    /**
     * POST insert a new product
     * 
     * @param array $data
     * @return void
     */
    public function addProduct($data)
    {
        (new Auth())->validateLogin();

        $Product = new Product();

        foreach ($Product->getRequired() as $required) {
            if (!isset($data[$required])) {
                $this->Message->message = "parâmetro '{$required}' é requerido";
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
                return;
            }
        }

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $name = filter_var(trim($data["name"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $value = filter_var($data["value"], FILTER_VALIDATE_FLOAT);
        $description = filter_var(trim($data["description"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $available = filter_var($data["available"], FILTER_VALIDATE_INT);
        $product_type_id = filter_var($data["product_type_id"], FILTER_VALIDATE_INT);

        if (!$value || !$available || !$product_type_id || empty($name) || empty($description)) {
            $this->Message->message = 'parâmetro inválido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $Category = new Category();

        if (is_null($Category->findById($product_type_id, 'id'))) {
            $this->Message->message = 'esta categoria não existe';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $Product = new Product();

        if (isset($data['id'])) {
            $id = filter_var($data["id"], FILTER_VALIDATE_INT);
            
            if (!$id) {
                $this->Message->message = 'este produto não foi encontrado';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }

            if (!is_null($Product->findById($id, 'id'))) {
                $Product->id = $id;
            }
        }

        /** Criar produto */
        $Product->name = $name;
        $Product->value = $value;
        $Product->description = $description;
        $Product->available = $available;
        $Product->product_type_id = $product_type_id;

        if (!$Product->save()) {
            $this->Message->message = $Product->message();
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        }

        $ProductImage = new ProductImage();

        $ProductImage->product_id = $Product->id;
        $ProductImage->url_slug = '/images/no-product-image.png';
        $ProductImage->real_path = '/images/no-product-image.png';

        if (!$ProductImage->save()) {
            erro_log($ProductImage->message());
        }

        $this->Message->message = 'Produto adicionado com sucesso';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function alterProduct($data)
    {
        (new Auth())->validateLogin();

        $Product = new Product();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (!isset($data['id'])) {
            $this->Message->message = 'ID do produto é requerido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        if (!$id) {
            $this->Message->message = 'parâmetro inválido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        if (is_null(($Product = $Product->findById($id, '*')))) {
            $this->Message->message = 'este produto não foi encontrado';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $productData = &$Product->data();

        if (isset($data["name"])) {
            $name = filter_var(trim($data["name"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!$name) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }

            $productData->name = $name;
        }

        if (isset($data["value"])) {
            $value = filter_var(trim($data["value"]), FILTER_VALIDATE_FLOAT);

            if (!$value) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }

            $productData->value = $value;
        }

        if (isset($data["description"])) {
            $description = filter_var($data["description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!$description) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }

            $productData->description = $description;
        }

        if (isset($data["available"])) {
            $available = filter_var($data["available"], FILTER_VALIDATE_INT);

            if (!$available) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }

            $productData->available = $available;
        }

        if (isset($data["product_type_id"])) {
            $product_type_id = filter_var($data["product_type_id"], FILTER_VALIDATE_INT);

            if (!$product_type_id) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }

            $Category = new Category();

            if (is_null($Category->findById($product_type_id, 'id'))) {
                $this->Message->message = 'esta categoria não existe';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }

            $productData->product_type_id = $product_type_id;
        }

        if (!$Product->save()) {
            $this->Message->message = $Product->message();
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        }

        $this->Message->message = 'Produto atualizado com sucesso';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
}
