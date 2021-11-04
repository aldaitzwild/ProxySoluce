<?php

namespace App\Model;

use PDO;

class OfferingManager extends AbstractManager
{
    private const TABLE_OFFERING = 'offering';
    private const TABLE_PERSON = 'person';
    private const TABLE_CATEGORY = 'category';

    public function selectByCategory(array $data): array
    {
        $statement = $this->pdo->prepare("SELECT p.name, p.forname, o.title, o.city, o.description, c.name AS category
        FROM " . self::TABLE_OFFERING . " AS o
        JOIN " . self::TABLE_PERSON . " AS p ON o.person_id=p.id
        JOIN " . self::TABLE_CATEGORY . " AS c ON o.category_id=c.id
        HAVING category=:category AND o.city=:city;");
        $statement->bindValue('category', $data['category'], \PDO::PARAM_STR);
        $statement->bindValue('city', $this->formatCity($data['city']), \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    private function formatCity(string $city): string
    {
        return ucfirst(strtolower($city));
    }
}
