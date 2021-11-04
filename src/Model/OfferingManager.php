<?php

namespace App\Model;

use PDO;

class OfferingManager extends AbstractManager
{
    public const TABLE_OFFERING = 'offering';
    public const TABLE_DOING = 'doing';
    public const TABLE_PERSON = 'person';
    public const TABLE_CATEGORY = 'category';
    public const TABLE_SKILL = 'skill';

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

    public function getAllCategories(): array
    {
        $statement = $this->pdo->query("SELECT name FROM " . self::TABLE_CATEGORY);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSkills(): array
    {
        $statement = $this->pdo->query("SELECT name FROM " . self::TABLE_SKILL);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function formatCity(string $city): string
    {
        return ucfirst(strtolower($city));
    }
}
