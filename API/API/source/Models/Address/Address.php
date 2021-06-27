<?php

namespace Source\Models\Address;

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
        parent::__construct('address', ['id'], ['city_id', 'street', 'cep', 'number']);
    }

    /**
     * @param int $city_id
     * @param string $street
     * @param string $cep
     * @param int $number
     * @return Address
     */
    public function bootstrap(int $city_id, string $street, string $cep, int $number): Address
    {
        $this->city_id = $city_id;
        $this->street = $street;
        $this->cep = $cep;
        $this->number = $number;
        return $this;
    }

    public static function bindAddress(int $userId, int $addressId)
    {
        try {
            $stmt = Connect::getInstance()->prepare("INSERT INTO redstore.user_address (user_id, address_id, created_by, created_at, updated_at) VALUES (:userId, :addressId, :userId2, NOW(), NOW());");
            $stmt->bindValue(":userId", $userId, \PDO::PARAM_INT);
            $stmt->bindValue(":addressId", $addressId, \PDO::PARAM_INT);
            $stmt->bindValue(":userId2", $userId, \PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (\PDOException $exception) {
            return null;
        }
    }

    public static function getAddressByUserId(int $userId)
    {
        try {
            $stmt = Connect::getInstance()->prepare("SELECT redstore.address.* FROM redstore.address INNER JOIN redstore.user_address ON redstore.address.id = redstore.user_address.address_id WHERE redstore.user_address.user_id = :userId;");
            $stmt->bindValue(":userId", $userId, \PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt->rowCount()) {
                return null;
            }

            return $stmt->fetchAll();
        } catch (\PDOException $exception) {
            return null;
        }
    }

    public static function getBindedAddress(int $userId, int $addressId)
    {
        try {
            $stmt = Connect::getInstance()->prepare("SELECT user_id, address_id FROM redstore.user_address WHERE user_id = :userId AND address_id = :addressId;");
            $stmt->bindValue(":userId", $userId, \PDO::PARAM_INT);
            $stmt->bindValue(":addressId", $addressId, \PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt->rowCount()) {
                return null;
            }

            return $stmt->fetchAll();
        } catch (\PDOException $exception) {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        /** Address Update */
        if (!empty($this->id)) {
            $addressId = $this->id;

            $this->update($this->safe(), "id = :id", "id={$addressId}");
            if ($this->fail()) {
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        if (!$this->required()) {
            $this->error = "Campos inválidos!";
            return false;
        }

        /** Address Create */
        if (empty($this->id)) {
            $addressId = $this->create($this->safe());
            if ($this->fail()) {
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($addressId))->data();
        return true;
    }
}
