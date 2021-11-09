<?php

namespace App\Model;

use PDO;

class SkillManager extends AbstractManager
{
    public const TABLE = 'skill';

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
}
