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

// Buscar os funcionários cadastrados
$sql_func = "SELECT * FROM Tbl_Funcionario";
$stmt_func = $pdo->query($sql_func);
$funcionarios = $stmt_func->fetchAll(PDO::FETCH_ASSOC);

// Buscar os registros
$sql_reg = "SELECT * FROM Tbl_Registros";
$stmt_reg = $pdo->query($sql_reg);
$registros = $stmt_reg->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Funcionários e Registros</title>
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

    <!-- Container principal para centralizar as tabelas -->
    <div class="container">
        <!-- Exibição dos Funcionários -->
        <div class="tabela">
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

        <!-- Exibição dos Registros -->
        <div class="tabela">
            <h2>Registros</h2>
            <?php if (count($registros) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Código Funcionário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registros as $registro): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($registro['Reg_codigo']); ?></td>
                                <td><?php echo htmlspecialchars($registro['Reg_Data']); ?></td>
                                <td><?php echo htmlspecialchars($registro['Reg_Hora']); ?></td>
                                <td><?php echo htmlspecialchars($registro['Fun_codigo']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nenhum registro encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
