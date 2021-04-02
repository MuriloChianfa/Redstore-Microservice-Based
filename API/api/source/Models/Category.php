<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class Category extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("category", ["id"], ["name"]);
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string|null $document
     * @return User
     */
    public function bootstrap(string $name): Category {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $name
     * @param string $columns
     * @return null|Category
     */
    public function findByName(string $name, string $columns = "*"): ?Category
    {
        $find = $this->find("name = :name", "name={$name}", $columns);

        return $find->fetch();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->error = "O nome da categoria é obrigatória";
            return false;
        }

        /** Category Update */
        if (!empty($this->id)) {
            $categoryId = $this->id;

            if ($this->find("name = :e AND id != :i", "e={$this->name}&i={$categoryId}", "id")->fetch()) {
                $this->error = "A categoria informada já está cadastrada";
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$categoryId}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** Category Create */
        if (empty($this->id)) {
            if ($this->findByName($this->name, 'id')) {
                $this->error = "A categoria informada já está cadastrada";
                return false;
            }

            $categoryId = $this->create($this->safe());
            if ($this->fail()) {
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($categoryId))->data();
        return true;
    }
}
