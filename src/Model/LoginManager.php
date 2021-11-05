<?php

namespace App\Model;

class LoginManager extends AbstractManager
{
    public const TABLE = 'Login';

    public function checkUser(array $user)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE `user` = :user");
        $statement->bindValue('user', $user['user'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function checkPass(array $pass)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE `pass` = :pass");
        $statement->bindValue('pass', password_hash($pass['pass'], PASSWORD_BCRYPT), \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
