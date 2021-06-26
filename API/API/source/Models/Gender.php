<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class Gender extends Model
{
    /**
     * Gender constructor.
     */
    public function __construct()
    {
        parent::__construct("gender", ["id"], ["name"]);
    }

    /**
     * @param string $name
     * @return Gender
     */
    public function bootstrap(string $name): Gender {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $name
     * @param string $columns
     * @return null|Gender
     */
    public function findByName(string $name, string $columns = "*"): ?Gender
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
            $this->error = "Faltam campos obrigatórios!";
            return false;
        }

        /** Gender Update */
        if (!empty($this->id)) {
            $genderId = $this->id;

            if ($this->find("name = :e AND id != :i", "e={$this->name}&i={$genderId}", "id")->fetch()) {
                $this->error = "O sexo informado já está cadastrado";
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$genderId}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** Gender Create */
        if (empty($this->id)) {
            if ($this->findByName($this->name, 'id')) {
                $this->error = "O sexo informado já está cadastrado";
                return false;
            }

            $genderId = $this->create($this->safe());
            if ($this->fail()) {
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($genderId))->data();
        return true;
    }
}
