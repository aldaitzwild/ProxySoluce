<?php

namespace App\Model;

class RegisterManager extends AbstractManager
{
    public const TABLE = 'person';

    public function insert(array $register): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "
        (`firstname` , `lastname`, `mail`, `birth`, `user`,`pass`, `adress`,`postal`, `town`, `picture`) 
        VALUES (:firstname , :lastname, :mail,:birth, :user, :pass, :adress, :postal, :town, :picture)");
        $statement->bindValue('pass', password_hash($register['pass'], PASSWORD_BCRYPT), \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $register['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $register['lastname'], \PDO::PARAM_STR);
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

    public function update(array $register, int $id): bool
    {
        $query = null;
        if (!isset($register['picture'])) {
            $query = "UPDATE " . self::TABLE . " 
            SET 
            firstname=:firstname,
            lastname=:lastname,
            mail=:mail,
            birth=:birth,
            user=:user,
            pass=:pass,
            adress=:adress,
            postal=:postal,
            town=:town 
            WHERE id=:id;";
        } else {
            $query = "UPDATE " . self::TABLE . " 
            SET 
            firstname=:firstname,
            lastname=:lastname,
            mail=:mail,
            birth=:birth,
            user=:user,
            pass=:pass,
            adress=:adress,
            postal=:postal,
            town=:town,
            picture=:picture 
            WHERE id=:id;";
        }

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':pass', password_hash($register['pass'], PASSWORD_BCRYPT), \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $register['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $register['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':mail', $register['mail'], \PDO::PARAM_STR);
        $statement->bindValue(':birth', $register['birth'], \PDO::PARAM_STR);
        $statement->bindValue(':user', $register['user'], \PDO::PARAM_STR);
        $statement->bindValue(':adress', $register['adress'], \PDO::PARAM_STR);
        $statement->bindValue(':postal', $register['postal'], \PDO::PARAM_INT);
        $statement->bindValue(':town', $register['town'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        if (isset($register['picture'])) {
            $statement->bindValue(':picture', $register['picture'], \PDO::PARAM_STR);
        }

        return $statement->execute();
    }

    public function deleteUserById(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE .  " WHERE id=:id;");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
