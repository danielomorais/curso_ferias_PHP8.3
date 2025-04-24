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
    $id = $_GET['id'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomeDoProduto = $_POST['nome'];
        $descricaoDoProduto = $_POST['descricao'];
        $precoDoProduto = $_POST['preco'];

        $sql = "INSERT INTO produtos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':nome', $nomeDoProduto);
        $statement->bindParam(':descricao', $descricaoDoProduto);
        $statement->bindParam(':preco', $precoDoProduto);
        $statement->execute();
    }

    $sql = 'SELECT `p`.`id`, `c`.`titulo` AS `categoria`, `p`.`nome`, `p`.`descricao`, `p`.`preco` FROM produtos AS `p`
            LEFT JOIN categorias AS `c` ON `c`.`id` = `p`.`categoria_id`';
    $statement = $pdo->query($sql);
    $produtos = $statement->fetchAll();
} catch (PDOException $exception) {
    die("Não foi possível se conectar com o banco de dados. Motivo: {$exception->getMessage()}");
}; 

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha primeira aplicação com PHP + PDO + MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-5 mb-4">Meus produtos</h1>
                
                <table class="table table-dark table-hover table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Nome do produto</th>
                        <th>Categoria do produto</th>
                        <th>Preço do produto</th>
                    </tr>

                    <?php foreach($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['id']?></td>
                        <td><?php echo $produto['nome']?></td>
                        <td><?php echo $produto['categoria']?></td>
                        <td><?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>

                </table>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5 mb-4">Cadasto de produtos</h2>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Produto</label>
                        <input type="text" class="form-control" id="nome" name="nome">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao">
                    </div>
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço</label>
                        <input type="text" class="form-control" id="preco" name="preco">
                    </div>
                    <button class="btn btn-success">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>