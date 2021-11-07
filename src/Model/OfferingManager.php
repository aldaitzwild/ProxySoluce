<?php

namespace App\Model;

class OfferingManager extends AbstractManager
{
    public const TABLE = 'offering';
       
    public function insert(array $offering): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (title, description,city, category_id) 
                                                         VALUES (:title,:description,:city,:category);");
        $statement->bindValue('title', $offering['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $offering['description'], \PDO::PARAM_STR);
        $statement->bindValue('city', $offering['city'], \PDO::PARAM_STR);
        $statement->bindValue('category', $offering['category'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }    
}
