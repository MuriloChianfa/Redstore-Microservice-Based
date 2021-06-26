<?php

namespace Source\Controllers;

use \stdClass;

use Source\Core\Request;
use Source\Core\Response;

use Source\Models\Category;

class Categories
{
    private $Message;

    private $Request;

    public function __construct()
    {
        $this->Message = new stdClass();
        $this->Request = new Request();
    }

    public function categories()
    {
        $Category = new Category();

        /** Criar categoria */
        // $Category->name = "Coleção de verão";
        
        // if (!$Category->save()) {
        //     $this->Message->message = $Category->message();
        // }
        // else {
        //     $this->Message->message = 'Categoria adicionada com sucesso';
        // }

        $this->Message->message = $Category->findAll();
        
        (new Response())->setStatusCode(HTTP_OK)->send($this->Message);
    }
}
