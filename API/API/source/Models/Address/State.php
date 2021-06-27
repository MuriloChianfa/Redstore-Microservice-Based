<?php

namespace Source\Models\Address;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class State extends Model
{
    /**
     * State constructor.
     */
    public function __construct()
    {
        parent::__construct("state", ["id"], ["name", "acronym"]);
    }

    /**
     * @param string $name
     * @param string $acronym
     * @return State
     */
    public function bootstrap(string $name, string $acronym): State
    {
        $this->name = $name;
        $this->acronym = $acronym;
        return $this;
    }

    /**
     * @param string $name
     * @param string $columns
     * @return null|State
     */
    public function findByName(string $name, string $columns = "*"): ?State
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

        /** State Update */
        if (!empty($this->id)) {
            $stateId = $this->id;

            if ($this->find("name = :e AND id != :i", "e={$this->name}&i={$stateId}", "id")->fetch()) {
                $this->error = "O estado informado já está cadastrado!";
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$stateId}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** State Create */
        if (empty($this->id)) {
            if ($this->find("name = :e AND id != :i", "e={$this->name}&i={$this->id}", "id")->fetch()) {
                $this->error = "O estado informado já está cadastrado!";
                return false;
            }

            $stateId = $this->create($this->safe());
            if ($this->fail()) {
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($stateId))->data();
        return true;
    }
}
