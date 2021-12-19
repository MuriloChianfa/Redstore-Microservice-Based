<?php

namespace Source\Controllers;

use stdClass;
use Source\Core\Request;
use Source\Core\Response;
use Source\Models\Product;
use Source\Models\ProductImage;
use Source\Models\Category;

trait ProductFunctions
{
    private function validateSingleProductId($data)
    {
        if (empty($data['id'])) {
            $this->Message->message = 'ID do produto inválido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);

        if (!$id) {
            $this->Message->message = 'parâmetro inválido';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        return $id;
    }

    private function validateProductId($data)
    {
        if (!isset($data['id'])) {
            $this->Message->message = 'Id do produto inválido!';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        if (!$id) {
            $this->Message->message = 'Id do produto inválido!';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $Product = new Product();
        $Product = $Product->findById($id, 'id');

        if (is_null($Product)) {
            $this->Message->message = 'Produto não encontrado!';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        return $Product;
    }

    private function allProductsWithoutFilters($data)
    {
        if (!empty($data)) {
            return;
        }

        if (is_null(($products = $Product->findAll()))) {
            (new Response())->setStatusCode(HTTP_NO_CONTENT)->send($this->Message);
        }

        $this->Message->message = $products;
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    private function validatePagination($data)
    {
        if (!isset($data['page']) || !isset($data['limit'])) {
            $this->Message->message = [
                'message' => 'Missing page or limit argument'
            ];

            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }
    }

    private function validateOrderAndDirection($data)
    {
        if (!isset($data['order']) || !isset($data['direction'])) {
            return;
        }

        $page = filter_var($data['page'], FILTER_VALIDATE_INT);
        $limit = filter_var($data['limit'], FILTER_VALIDATE_INT);

        $find = $this->validateSearchFilters($data);

        $find = $find->order($data['order'] . ' ' . $data['direction']);
        $find = $find->limit($limit);
        $find = $find->offset(($page * $limit) - $limit);
        $products = $find->fetch(true);

        if (empty($products)) {
            (new Response())->setStatusCode(HTTP_NO_CONTENT)->send($this->Message);
        }

        foreach ($products as $key => $value) {
            $products[$key] = $value->data();

            $products[$key]->category = (new Category())->findById((int) $products[$key]->product_type_id)->data();
            $products[$key]->ProductImage = (new ProductImage())->findAllByProductId((int) $products[$key]->id);
        }

        $this->Message->message = $products;
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }

    private function validateSearchFilters($data)
    {
        $Product = new Product();

        if (empty($data['filterColumn'])) {
            return $Product->find();
        }

        if (empty($data['selfId'])) {
            return $Product->find("{$data['filterColumn']} = {$data['filterValue']}");
        }

        return $Product->find("{$data['filterColumn']} = {$data['filterValue']} AND id != {$data['selfId']}");
    }

    private function validateImageUpload($data)
    {
        if (empty($data['image'])) {
            $this->Message->message = 'imagem nao encontrada';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        $base64Image = $data['image'];

        try {
            $base64 = getimagesizefromstring(base64_decode(explode(',', $base64Image)[1]));
        } catch (\Exception $e) {
            $this->Message->message = 'imagem invalida';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        if (!$base64) {
            $this->Message->message = 'imagem invalida';
            (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
        }

        if (!empty($base64[0]) && !empty($base64[0]) && !empty($base64['mime'])) {
            if (!in_array($base64['mime'], $this->validExtensions)) {
                $this->Message->message = 'tipo de imagem invalida';
                (new Response())->setStatusCode(HTTP_BAD_REQUEST)->send($this->Message);
            }
        }

        return $base64Image;
    }
}
