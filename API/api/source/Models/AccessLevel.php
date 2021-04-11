<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class AccessLevel extends Model
{
    /**
     * AccessLevel constructor.
     */
    public function __construct()
    {
        parent::__construct("access_level", ["id"], ["name"]);
    }

    /**
     * @param string $name
     * @return AccessLevel
     */
    public function bootstrap(string $name): AccessLevel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $name
     * @param string $columns
     * @return null|AccessLevel
     */
    public function findByName(string $name, string $columns = "*"): ?AccessLevel
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

        /** AccessLevel Update */
        if (!empty($this->id)) {
            $accessLevelId = $this->id;

            if ($this->find("name = :e AND id != :i", "e={$this->name}&i={$accessLevelId}", "id")->fetch()) {
                $this->error = "O sexo informado já está cadastrado";
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$accessLevelId}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** AccessLevel Create */
        if (empty($this->id)) {
            if ($this->findByName($this->name, 'id')) {
                $this->error = "O sexo informado já está cadastrado";
                return false;
            }

            $accessLevelId = $this->create($this->safe());
            if ($this->fail()) {
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($accessLevelId))->data();
        return true;
    }
}
