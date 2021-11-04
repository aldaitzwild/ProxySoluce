<?php

namespace App\Model;

use PDO;

class SkillManager extends AbstractManager
{
    public const TABLE_SKILL = 'skill';

    public function getAllSkills(): array
    {
        $statement = $this->pdo->query("SELECT name FROM " . self::TABLE_SKILL);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
