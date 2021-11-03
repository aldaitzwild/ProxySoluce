<?php

namespace App\Model;

class CategoryManager extends AbstractManager
{
    public const TABLEb = 'category';

    public function insert(array $category): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLEb . " (name) VALUES (:name)");
        
        $statement->bindValue('name', $category['name'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

}