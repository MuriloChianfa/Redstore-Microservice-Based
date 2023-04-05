<?php

namespace Source\Controllers;

use stdClass;
use Source\Core\Request;
use Source\Core\Response;
use Source\Models\Product;
use Source\Models\Category;
use Source\Models\ProductImage;
use Source\Core\Rabbit\RabbitSender;
use Source\Controllers\ProductFunctions;

class Products
{
    use ProductFunctions;

    /**
     * @var \stdClass $Message
     */
    private $Message;

    /**
     * @var Request $Request
     */
    private $Request;

    /**
     * @var array $validExtensions
     */
    private $validExtensions = [
        'image/jpeg',
        'image/jpg',
        'image/png'
    ];

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

        $this->allProductsWithoutFilters($data);
        $this->validatePagination($data);

        $page = filter_var($data['page'], FILTER_VALIDATE_INT);
        $limit = filter_var($data['limit'], FILTER_VALIDATE_INT);

        $this->validateOrderAndDirection($data);

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

        $id = $this->validateSingleProductId($data);

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

        $this->Message->message = 'Produto adicionado com sucesso';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    /**
     * POST insert a new product image to one product
     *
     * @param array $data
     * @return void
     */
    public function addProductImage($data)
    {
        (new Auth())->validateLogin();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $Product = $this->validateProductId($data);

        $ProductImage = new ProductImage();
        $imageName = md5(date('Y-m-dH:i:s', time()));

        $base64Image = $this->validateImageUpload($data);

        error_log($Product->id);
        error_log($imageName);
        // error_log($base64Image);

        $ProductImage->product_id = $Product->id;
        $ProductImage->url_slug = $imageName;
        $ProductImage->image = $base64Image;

        if (!$ProductImage->save()) {
            $this->Message->message = $ProductImage->message();
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        }

        $this->Message->message = 'Imagem adicionada com sucesso';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    /**
     * DELETE delete one product image by id
     *
     * @param array $data
     * @return void
     */
    public function deleteProductImage($data)
    {
        (new Auth())->validateLogin();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $ProductImage = new ProductImage();

        if (!isset($data['id']) || !filter_var($data['id'], FILTER_VALIDATE_INT)) {
            $this->Message->message = 'ID da imagem invalida';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $id = (int) $data['id'];

        if (is_null($ProductImage->findById($id, 'id'))) {
            $this->Message->message = 'Imagem nao encontrada';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        if (!$ProductImage->delete('id', $id)) {
            $this->Message->message = $ProductImage->message();
            (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
        }

        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    public function alterProduct($data)
    {
        (new Auth())->validateLogin();

        $Product = new Product();

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $id = $this->validateSingleProductId($data);

        if (is_null(($Product = $Product->findById($id, '*')))) {
            $this->Message->message = 'este produto não foi encontrado';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $productData = &$Product->data();

        $fields = [
            'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'value' => FILTER_VALIDATE_FLOAT,
            'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'available' => FILTER_VALIDATE_INT
        ];

        foreach ($fields as $key => $filter) {
            if (!isset($data[$key])) {
                continue;
            }

            $$key = filter_var(trim($data[$key]), $filter);

            if (!$$key) {
                $this->Message->message = "Parâmetro {$key} inválido!";
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }

            $productData->$key = $$key;
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

    public function checkoutSuccess()
    {
        (new Auth())->validateLogin();

        (new RabbitSender('email', 'email'))->sendMessage(json_encode([
            'type' => 'checkout',
            'content' => [
                'product_id' => 0
            ]
        ]));

        $this->Message->message = 'Produto foi pedido com sucesso';
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
}
