<?php

namespace App\Model;

class OfferingManager extends AbstractManager
{
    public const TABLE_PERSON = 'person';
    public const TABLE = 'offering';

    public function insert(array $offering): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (title, description,city,category_id) 
                                        VALUES (:title,:description,:city,:category);");
        $statement->bindValue('title', $offering['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $offering['description'], \PDO::PARAM_STR);
        $statement->bindValue('city', $offering['city'], \PDO::PARAM_STR);
        $statement->bindValue('category', $offering['category'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectByCategory(array $data): array
    {
        $statement = $this->pdo->prepare("SELECT p.firstname,
        p.lastname, o.id, o.title, o.city, o.description, c.name AS category
        FROM " . self::TABLE . " AS o
        JOIN " . self::TABLE_PERSON . " AS p ON o.person_id=p.id
        JOIN " . CategoryManager::TABLE . " AS c ON o.category_id=c.id
        HAVING category=:category AND o.city=:city;");
        $statement->bindValue('category', $data['category'], \PDO::PARAM_STR);
        $statement->bindValue('city', $this->formatCity($data['city']), \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOfferById($id): array
    {
        $statement = $this->pdo->prepare("SELECT p.firstname,
        p.lastname, p.mail, o.id, o.title, o.city, o.description, c.name AS category
        FROM " . self::TABLE . " AS o
        JOIN " . self::TABLE_PERSON . " AS p ON o.person_id=p.id
        JOIN " . CategoryManager::TABLE . " AS c ON o.category_id=c.id
        HAVING o.id=:id;");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }


    private function formatCity(string $city): string
    {
        return ucfirst(strtolower($city));
    }
}
