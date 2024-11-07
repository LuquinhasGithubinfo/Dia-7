<?php
// Conectar ao banco de dados
$host = 'localhost'; 
$dbname = 'Empresa';
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
    exit;
}

// Processar o cadastro de um novo funcionário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];

    if (!empty($nome) && !empty($cargo)) {
        $sql = "INSERT INTO Tbl_Funcionario (Fun_Nome, Fun_Cargo) VALUES (:nome, :cargo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cargo', $cargo);
        $stmt->execute();
    }
}

// Buscar todos os funcionários cadastrados
$sql = "SELECT * FROM Tbl_Funcionario";
$stmt = $pdo->query($sql);
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionário</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>

    <!-- Menu de navegação -->
    <div class="menu">
        <a href="menu.php"><button>Menu</button></a>
        <a href="Cadastro.php"><button>Cadastro</button></a>
        <a href="Visualizar.php"><button>Visualizar</button></a>
        <a href="alterar.php"><button>Alteração</button></a>
    </div>

    <!-- Container principal (para centralizar o conteúdo na tela) -->
    <div class="container">
        <!-- Formulário de Cadastro -->
        <div class="formulario">
            <h1>Cadastrar Novo Funcionário</h1>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome do Funcionário" required>
                <input type="text" name="cargo" placeholder="Cargo do Funcionário" required>
                <button type="submit">Cadastrar</button>
            </form>
        </div>

        <!-- Exibição dos Funcionários -->
        <div class="funcionarios">
            <h2>Funcionários Cadastrados</h2>
            <?php if (count($funcionarios) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($funcionarios as $funcionario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($funcionario['Fun_codigo']); ?></td>
                                <td><?php echo htmlspecialchars($funcionario['Fun_Nome']); ?></td>
                                <td><?php echo htmlspecialchars($funcionario['Fun_Cargo']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nenhum funcionário cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
