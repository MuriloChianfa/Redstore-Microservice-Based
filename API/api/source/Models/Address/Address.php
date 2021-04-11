<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\Connect;

/**
 * @package Source\Models
 */
class Address extends Model
{
    /**
     * Address constructor.
     */
    public function __construct()
    {
        parent::__construct("phone", ["id"], ["user_id", "phone_type_id", "number"]);
    }

    /**
     * @param int $user_id
     * @param int $phone_type_id
     * @param int $phone_type_id
     * @return Address
     */
    public function bootstrap(int $user_id, int $phone_type_id, int $number): Address
    {
        $this->user_id = $user_id;
        $this->phone_type_id = $phone_type_id;
        $this->number = $number;
        return $this;
    }

    /**
     * @param string $userId
     * @return null|Phone
     */
    public function findByUserId(string $userId)
    {
        try {
            $stmt = Connect::getInstance()->prepare("SELECT phone.number, phone_type.name FROM redstore.phone INNER JOIN redstore.phone_type ON phone_type.id = phone.phone_type_id WHERE phone.user_id = :userId;");
            $stmt->bindValue(":userId", $userId, \PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt->rowCount()) {
                return null;
            }

            return $stmt->fetchAll();
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
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

        /** Phone Update */
        if (!empty($this->id)) {
            $phoneId = $this->id;

            $this->update($this->safe(), "id = :id", "id={$phoneId}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** Phone Create */
        if (empty($this->id)) {
            $phoneId = $this->create($this->safe());
            if ($this->fail()) {
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($phoneId))->data();
        return true;
    }
}
