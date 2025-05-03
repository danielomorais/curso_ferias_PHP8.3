<?php
namespace App\Models;

use PDO;
use PDOException;

class BaseModel
{
    private \PDO $pdo;
    protected string $table;

    public function __construct()
    {
        $host = 'localhost';
        $db = 'curso_ferias';
        $user = 'root';
        $password = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        try {
            $this->pdo = new \PDO($dsn, $user, $password, $options);
            echo 'Banco de dados conectado!';
        } catch (PDOException $exception) {
            die('Conexão não realizada com o banco de dados. Error: ' . $exception->getMessage());
        }
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll();
    }

    public function getById(int $id): array
    {
        $sql =  "SELECT * FROM {$this->table} WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        
        return $statement->fetch();
    }

    public function insert(array $data): void
    {
        $keys = array_keys($data);
        $keysString = implode("`, `", $keys);

        $binds = array_map(function($key) {
            return ":{$key}";
        }, $keys);
        $bindString = implode(", ", $binds);
        
        $sql = "INSERT INTO {$this->table} (`{$keysString}`) VALUES ({$bindString})";

        $statement = $this->pdo->prepare($sql);

        for ($i = 0; $i < count($data); $i ++) {
            $statement->bindParam($binds[$i], $data[$keys[$i]]);
        }

        $statement->execute();
    }

}