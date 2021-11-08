<?php

namespace App\Model;

use PDO;

class SkillManager extends AbstractManager
{
    public const TABLE = 'skill';

    /** Insert skill off a person in database */
    public function insert(array $choose): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`) VALUES (:name)");
        $statement->bindValue('title', $choose['s.name'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
