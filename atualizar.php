<?php

// Chamando conexção com o DB
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions/gerenciar_produto.php';

// Realizando tratativa, que não é obrigatório porém é últil para tratar erros caso não seja realizada
// a conexão com o banco de dados

try { 
    $pdo = new PDO($dsn, $user, $password, $options);
    $id = $_GET['id'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nomeDoProduto = $_POST['nome'];
        $descricaoDoProduto = $_POST['descricao'];
        $precoDoProduto = $_POST['preco'];

        atualizarProduto($pdo, $nomeDoProduto, $descricaoDoProduto, $precoDoProduto, $id);

        header('location: index.php');
    }

    $produto = obterProdutoPorId($pdo, $id);

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
                <h2 class="mt-5 mb-4">Atualização de produtos</h2>

                <a href="index.php" class="btn btn-secondary">Voltar para produtos</a>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Produto</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $produto['nome'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $produto['descricao'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço</label>
                        <input type="text" class="form-control" id="preco" name="preco" value="<?php echo $produto['preco'];?>">
                    </div>
                    <button class="btn btn-success">Atualizar</button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>