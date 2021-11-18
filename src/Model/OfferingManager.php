<?php

namespace App\Model;

class OfferingManager extends AbstractManager
{
    public const TABLE_PERSON = 'person';
    public const TABLE = 'offering';

    public function insert(array $offering, int $userId): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (title, description,city,person_id,category_id) 
                                        VALUES (:title,:description,:city,:person_id,:category);");
        $statement->bindValue('title', $offering['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $offering['description'], \PDO::PARAM_STR);
        $statement->bindValue('city', $offering['city'], \PDO::PARAM_STR);
        $statement->bindValue('category', $offering['category'], \PDO::PARAM_INT);
        $statement->bindValue('person_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectByCategoryAndCity(array $data): array
    {
        $statement = $this->pdo->prepare("SELECT p.firstname,
        p.lastname, p.id as userid, o.id, o.title, o.city, o.description, c.name AS category, o.person_id
        FROM " . self::TABLE . " AS o
        JOIN " . self::TABLE_PERSON . " AS p ON o.person_id=p.id
        JOIN " . CategoryManager::TABLE . " AS c ON o.category_id=c.id
        HAVING category=:category AND o.city=:city;");
        $statement->bindValue('category', $data['category'], \PDO::PARAM_STR);
        $statement->bindValue('city', $this->formatCity($data['city']), \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectByCategory(string $category): array
    {
        $statement = $this->pdo->prepare("SELECT p.firstname,
        p.lastname, p.id as userid, o.id, o.title, o.city, o.description, c.name AS category, o.person_id
        FROM " . self::TABLE . " AS o
        JOIN " . self::TABLE_PERSON . " AS p ON o.person_id=p.id
        JOIN " . CategoryManager::TABLE . " AS c ON o.category_id=c.id
        HAVING category=:category");
        $statement->bindValue('category', $category, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectByUserId(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT p.firstname,
        p.lastname, p.id as userid, o.id, o.title, o.city, o.description, c.name AS category, o.person_id
        FROM " . self::TABLE . " AS o
        JOIN " . self::TABLE_PERSON . " AS p ON o.person_id=p.id
        JOIN " . CategoryManager::TABLE . " AS c ON o.category_id=c.id
        HAVING p.id=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOfferById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT p.firstname,
        p.lastname, p.mail, o.id, o.title, o.city, o.description, c.name AS category, o.person_id
        FROM " . self::TABLE . " AS o
        JOIN " . self::TABLE_PERSON . " AS p ON o.person_id=p.id
        JOIN " . CategoryManager::TABLE . " AS c ON o.category_id=c.id
        HAVING o.id=:id;");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function deleteOffersByUserId(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE .  " WHERE person_id=:id;");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    private function formatCity(string $city): string
    {
        return ucfirst(strtolower($city));
    }

    public function update(array $offering): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title,
        `city` = :city, `description` = :description WHERE id=:id");
        $statement->bindValue('id', $offering['id'], \PDO::PARAM_STR);
        $statement->bindValue('title', $offering['title'], \PDO::PARAM_STR);
        $statement->bindValue('city', $offering['city'], \PDO::PARAM_STR);
        $statement->bindValue('description', $offering['description'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function showAllOffer()
    {
        $statement = $this->pdo->prepare("SELECT  p.firstname, p.lastname, o.id, o.title, o.city, c.name
        AS category, o.person_id
        FROM " . self::TABLE . " AS o
        JOIN " . self::TABLE_PERSON . " AS p ON o.person_id=p.id
        JOIN " . CategoryManager::TABLE . " AS c ON o.category_id=c.id 
        ORDER BY id DESC;");
        $statement->execute();
        return $statement->fetchAll();
    }
}
