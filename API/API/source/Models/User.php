<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("user", ["id"], ["first_name", "last_name", "email", "password"]);
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string|null $document
     * @return User
     */
    public function bootstrap(
        string $first_name,
        string $last_name,
        string $email,
        string $password
    ): User {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->cpf = 00000000000;
        return $this;
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|User
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {
        $find = $this->find("email = :email", "email={$email}", $columns);

        return $find->fetch();
    }

    public function updateUser(): bool
    {
        $userId = $this->id;

        if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}", "id")->fetch()) {
            $this->error = "O e-mail informado já está cadastrado";
            return false;
        }

        $this->update($this->safe(), "id = :id", "id={$userId}");

        if ($this->fail()) {
            $this->error = "Erro ao atualizar, verifique os dados";
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->error = "Nome, email e senha são obrigatórios";
            return false;
        }

        if (!is_email($this->email)) {
            $this->error = "O e-mail informado não tem um formato válido";
            return false;
        }

        if (!is_passwd($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->error = "A senha deve ter entre {$min} e {$max} caracteres";
            return false;
        } else {
            $this->password = passwd($this->password);
        }

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}", "id")->fetch()) {
                $this->error = "O e-mail informado já está cadastrado";
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                error_log(($this->fail())->getMessage());
                $this->error = "Erro ao atualizar, verifique os dados";
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email, 'id')) {
                $this->error = "O e-mail informado já está cadastrado";
                return false;
            }

            $userId = $this->create($this->safe());
            if ($this->fail()) {
                error_log(($this->fail())->getMessage());
                $this->error = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return true;
    }
}
