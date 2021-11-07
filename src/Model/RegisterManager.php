<?php

namespace App\Model;

class RegisterManager extends AbstractManager
{
    public const TABLE = 'Login';

    public function insert(array $register): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "
        (`name` , `firstname`, `mail`, `birth`, `user`,`pass`, `adress`,`postal`, `town`, `picture`) 
        VALUES (:name , :firstname, :mail,:birth, :user, :pass, :adress, :postal, :town, :picture)");
        $statement->bindValue('pass', password_hash($register['pass'], PASSWORD_BCRYPT), \PDO::PARAM_STR);
        $statement->bindValue(':name', $register['name'], \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $register['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':mail', $register['mail'], \PDO::PARAM_STR);
        $statement->bindValue(':birth', $register['birth'], \PDO::PARAM_STR);
        $statement->bindValue(':user', $register['user'], \PDO::PARAM_STR);
        $statement->bindValue(':adress', $register['adress'], \PDO::PARAM_STR);
        $statement->bindValue(':postal', $register['postal'], \PDO::PARAM_INT);
        $statement->bindValue(':town', $register['town'], \PDO::PARAM_STR);
        $statement->bindValue(':picture', $register['picture'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
