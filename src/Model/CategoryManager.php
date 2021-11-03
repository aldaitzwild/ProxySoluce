<?php

namespace App\Model;

class CategoryManager extends AbstractManager
{
    public const TABLEB = 'category';

    public function insert(array $category): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLEB . " (name) VALUES (:name)");
        $statement->bindValue('name', $category['name'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
