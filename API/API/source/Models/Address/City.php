<?php

namespace Source\Models\Address;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class City extends Model
{
    /**
     * City constructor.
     */
    public function __construct()
    {
        parent::__construct("city", ["id"], ["state_id", "ibge", "name"]);
    }

    /**
     * @param int $state_id
     * @param int $ibge
     * @param string $name
     * @return City
     */
    public function bootstrap(int $state_id, int $ibge, string $name): City
    {
        $this->state_id = $state_id;
        $this->ibge = $ibge;
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $name
     * @param string $columns
     * @return null|City
     */
    public function findByName(string $name, string $columns = "*"): ?City
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

        /** City Update */
        if (!empty($this->id)) {
            $cityId = $this->id;

            if ($this->find("name = :e AND state_id = :s AND id != :i", "e={$this->name}&i={$cityId}&s={$this->state_id}", "id")->fetch()) {
                $this->error = "A cidade informada já está cadastrada!";
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$cityId}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** City Create */
        if (empty($this->id)) {
            if ($this->find("name = :e AND state_id = :s AND id != :i", "e={$this->name}&i={$this->id}&s={$this->state_id}", "id")->fetch()) {
                $this->error = "A cidade informada já está cadastrada!";
                return false;
            }

            $cityId = $this->create($this->safe());
            if ($this->fail()) {
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($cityId))->data();
        return true;
    }
}
