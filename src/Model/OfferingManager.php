<?php

namespace App\Model;

class OfferingManager extends AbstractManager
{
    public const TABLE_OFFERING = 'offering';
    

   
    public function insert(array $offering): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE_OFFERING . " (title, description,city) 
                                                                            VALUES (:title,:description,:city);");
        $statement->bindValue('title', $offering['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $offering['description'], \PDO::PARAM_STR);
        $statement->bindValue('city', $offering['city'], \PDO::PARAM_STR);
        //$statement->bindValue('category_id', $offering['category_id'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }    
}
