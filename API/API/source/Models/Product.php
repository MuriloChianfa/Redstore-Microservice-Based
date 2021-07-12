<?php

namespace Source\Models;

use Source\Core\Model;

use Source\Models\Category;
use Source\Models\ProductImage;

/**
 * @package Source\Models
 */
class Product extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("product", ["id"], ["name", "value", "description", "available", "product_type_id"]);
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $description
     * @param int $available
     * @param int $product_type_id
     * @return Product
     */
    public function bootstrap(
        string $name,
        string $value,
        string $description,
        int $available,
        int $product_type_id
    ): Product {
        $this->name = $name;
        $this->value = $value;
        $this->description = $description;
        $this->available = $available;
        $this->product_type_id = $product_type_id;
        return $this;
    }

    /**
     * @param string $name
     * @param string $columns
     * @return null|Product
     */
    public function findByName(string $name, string $columns = "*"): ?Product
    {
        $find = $this->find("name = :name", "name={$name}", $columns);

        return $find->fetch();
    }

    public function findAll(int $limit = null, int $offset = null): ?array
    {
        $find = $this->find();

        if (!empty($limit)) {
            $find = $find->limit($limit);
        }

        if (!empty($offset)) {
            $find = $find->offset($offset);
        }

        $find = $find->fetch(true);

        if (empty($find)) {
            return null;
        }

        $return = [];
        foreach ($find as $key => $value) {
            $result = $value->data();

            $result->category = (new Category())->findById((int) $result->product_type_id)->data();
            $result->ProductImage = (new ProductImage())->findAllByProductId((int) $result->id);
            
            $return[] = $result;
        }

        return $return;
    }

    public function findByProductId(int $id, string $columns = '*'): ?Product
    {
        $find = $this->find("id = :id", "id={$id}", $columns);

        $value = $find->fetch();

        if (empty($value)) {
            return null;
        }

        $value->category =(new Category())->findById((int) $value->product_type_id)->data();
        $value->ProductImage = (new ProductImage())->findAllByProductId((int) $value->id);

        return $value;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->error = "Nome, valor, descrição, categoria e estoque são obrigatórios";
            return false;
        }

        /** User Update */
        if (!empty($this->id)) {
            if ($this->find("name = :e AND id != :i", "e={$this->name}&i={$this->id}", "id")->fetch()) {
                $this->error = "O produto informado já está cadastrado";
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$this->id}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->find("name = :e", "e={$this->name}")->fetch()) {
                $this->error = "O produto informado já está cadastrado";
                return false;
            }

            $this->id = $this->create($this->safe());

            if ($this->fail()) {
                error_log($this->fail());
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($this->id))->data();
        return true;
    }
}
