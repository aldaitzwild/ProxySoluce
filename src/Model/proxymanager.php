par rapport à la base de donnéées
<?php
namespace App\Model;

class personManager extends AbstractManager
{
    public const TABLE = 'person';
    public function insert(array $item): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, forname, birth_date, mail, login, password) VALUES ((:name,:forname,:birth_date, :mail, :login, :password,)");
        $statement->bindValue(':name', $item['name'], \PDO::PARAM_STR);
        $statement->bindValue(':forname', $item['forname'], \PDO::PARAM_STR);
        $statement->bindValue(':birth_date', $item['birth_date'], \PDO::PARAM_DATE);
        $statement->bindValue(':mail', $item['mail'], \PDO::PARAM_STR);
        $statement->bindValue(':login', $item['login'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $item['password'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
   
}