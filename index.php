<?php
// Configurando onde a integração do DB será feita definindo o seguinte;
$host = 'localhost';
$db = 'curso_ferias';
$user = 'root';
$password = '';
$charset = 'utf8mb4';
$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

// Informando as opções de como será o formato dos dados recebidos e como serão tratados;
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
]; 

/* 
Não é obrigatório porém é últil para tratar erros
caso não seja realizada a conexão com o banco de dados
*/
try { 
    $pdo = new PDO($dsn, $user, $password, $options);
    $sql = ' SELECT `p`.`id`, `c`.`titulo` AS `categoria`, `p`.`nome`, `p`.`descricao`, `p`.`preco` FROM produtos AS `p`
        INNER JOIN categorias AS `c` ON `c`.`id` = `p`.`categoria_id`';
    $statement = $pdo->query($sql);
    $produtos = $statement->fetchAll();
    
    foreach ($produtos as $produtos) {
        echo "O produto {$produtos['nome']}, da categoria {$produtos['categoria']}, custa R$ " . number_format($produtos['preco'], 2, ',', '.') . "<br>";
    }
    
} catch (PDOException $exception) {
    die("Não foi possível se conectar com o banco de dados. Motivo: {$exception->getMessage()}");
};