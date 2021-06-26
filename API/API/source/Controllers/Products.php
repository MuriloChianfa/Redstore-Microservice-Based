<?php

namespace Source\Controllers;

use \stdClass;

use Source\Core\Request;
use Source\Core\Response;

use Source\Models\Product;
use Source\Models\Category;

class Products
{
    private $Message;

    private $Request;

    public function __construct()
    {
        $this->Message = new stdClass();
        $this->Request = new Request();
    }

    public function products($data)
    {
        $Product = new Product();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data["page"]) && empty($data["limit"])) {
            if (is_null(($products = $Product->findAll()))) {
                (new Response())->setStatusCode(HTTP_NO_CONTENT)->send($this->Message);
                return;
            }
            
            $this->Message->message = $products;
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $page = filter_var($data["page"], FILTER_VALIDATE_INT);
        $limit = filter_var($data["limit"], FILTER_VALIDATE_INT);

        if (is_null(($products = $Product->findAll($limit, ($page * $limit) - $limit)))) {
            (new Response())->setStatusCode(HTTP_NO_CONTENT)->send($this->Message);
            return;
        }
        
        $this->Message->message = $products;
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function product($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $id = filter_var(@$data["id"], FILTER_VALIDATE_INT);

        if (!$id) {
            $this->Message->message = 'parâmetro inválido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            return;
        }

        $Product = new Product();

        if (is_null(($product = $Product->findByProductId($id)))) {
            (new Response())->setStatusCode(HTTP_NO_CONTENT)->send($this->Message);
            return;
        }
        
        $this->Message->message = $product->data();
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

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
        $avaliable = filter_var($data["avaliable"], FILTER_VALIDATE_INT);
        $category_id = filter_var($data["category_id"], FILTER_VALIDATE_INT);

        if (!$value || !$avaliable || !$category_id || empty($name) || empty($description)) {
            $this->Message->message = 'parâmetro inválido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            return;
        }

        $Category = new Category();

        if (is_null($Category->findById($category_id, 'id'))) {
            $this->Message->message = 'esta categoria não existe';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            return;
        }

        $Product = new Product();

        if (isset($data['id'])) {
            $id = filter_var($data["id"], FILTER_VALIDATE_INT);
            
            if (!$id) {
                $this->Message->message = 'este produto não foi encontrado';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
                return;
            }

            if (!is_null($Product->findById($id, 'id'))) {
                $Product->id = $id;
            }
        }

        /** Criar produto */
        $Product->name = $name;
        $Product->value = $value;
        $Product->description = $description;
        $Product->avaliable = $avaliable;
        $Product->category_id = $category_id;
        
        if (!$Product->save()) {
            $this->Message->message = $Product->message();
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
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
            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);
            
        if (!$id) {
            $this->Message->message = 'parâmetro inválido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            return;
        }

        if (is_null(($Product = $Product->findById($id, '*')))) {
            $this->Message->message = 'este produto não foi encontrado';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            return;
        }

        $productData = &$Product->data();

        if (isset($data["name"])) {
            $name = filter_var(trim($data["name"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!$name) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
                return;
            }

            $productData->name = $name;
        }

        if (isset($data["value"])) {
            $value = filter_var(trim($data["value"]), FILTER_VALIDATE_FLOAT);

            if (!$value) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
                return;
            }

            $productData->value = $value;
        }

        if (isset($data["description"])) {
            $description = filter_var($data["description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!$description) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
                return;
            }

            $productData->description = $description;
        }

        if (isset($data["avaliable"])) {
            $avaliable = filter_var($data["avaliable"], FILTER_VALIDATE_INT);

            if (!$avaliable) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
                return;
            }

            $productData->avaliable = $avaliable;
        }

        if (isset($data["category_id"])) {
            $category_id = filter_var($data["category_id"], FILTER_VALIDATE_INT);

            if (!$category_id) {
                $this->Message->message = 'parâmetro inválido';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
                return;
            }

            $Category = new Category();

            if (is_null($Category->findById($category_id, 'id'))) {
                $this->Message->message = 'esta categoria não existe';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
                return;
            }

            $productData->category_id = $category_id;
        }
        
        if (!$Product->save()) {
            $this->Message->message = $Product->message();
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
            return;
        }

        $this->Message->message = 'Produto atualizado com sucesso';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
}
