<?php

namespace App\Model;

use PDO;

class CategoryManager extends AbstractManager
{
    private const TABLE_CATEGORY = 'category';

    public function getAllCategories(): array
    {
        $statement = $this->pdo->query("SELECT name FROM " . self::TABLE_CATEGORY);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}