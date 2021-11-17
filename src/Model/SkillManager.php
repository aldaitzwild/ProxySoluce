<?php

namespace App\Model;

use PDO;

class SkillManager extends AbstractManager
{
    public const TABLE = 'skill';
    public const TABLE_PERSON = 'person';
    public const TABLE_PERSON_SKILL = 'user_skill';

    /** Insert skill off a person in database */
    public function assignSkill(int $userId, array $skillIds): void
    {
        foreach ($skillIds as $skillId) {
            $statement = $this->pdo->prepare("INSERT INTO user_skill (`person_id`, `skill_id`)
            VALUES (:userId, :skillId)");
            $statement->bindValue('skillId', $skillId, PDO::PARAM_INT);
            $statement->bindValue('userId', $userId, PDO::PARAM_INT);
            $statement->execute();
        }
    }

    public function updateSkills(int $userId, array $skillIds): void
    {
        $statement = $this->pdo->prepare("DELETE FROM user_skill WHERE `person_id`=:userId;");
        $statement->bindValue('userId', $userId, PDO::PARAM_INT);
        $statement->execute();

        foreach ($skillIds as $skillId) {
            $statement = $this->pdo->prepare("INSERT INTO user_skill (`person_id`, `skill_id`)
            VALUES (:userId, :skillId)");
            $statement->bindValue('skillId', $skillId, PDO::PARAM_INT);
            $statement->bindValue('userId', $userId, PDO::PARAM_INT);
            $statement->execute();
        }
    }

    public function selectSkillsByUserId(int $userId): array
    {
        $statement = $this->pdo->prepare("SELECT s.name, us.person_id, us.skill_id AS id
        FROM " . static::TABLE_PERSON_SKILL . " AS us
        JOIN " . self::TABLE_PERSON . " AS p ON us.person_id=p.id 
        LEFT JOIN " . self::TABLE . " AS s ON s.id=us.skill_id
        HAVING us.person_id=:userid
        ORDER BY s.name ASC;");
        $statement->bindValue('userid', $userId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function deleteSkillsByUserId(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE_PERSON_SKILL .  " WHERE person_id=:id;");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
