<?php

namespace App\Model;

use Exception;

class LoginManager extends AbstractManager
{
    public const TABLE = 'person';

    public function checkInformations(array $userInformations): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE user = :user ;");
        $statement->bindValue('user', $userInformations['user'], \PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch();
        if (!$result) {
            throw new Exception("Les informations sont incorrectes");
        } else {
            return $result;
        }
    }
}
