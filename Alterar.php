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

// Alteração de dados de Funcionário
if (isset($_POST['alterar_funcionario'])) {
    $codigo = $_POST['codigo_funcionario'];
    $nome = $_POST['nome_funcionario'];
    $cargo = $_POST['cargo_funcionario'];

    if (!empty($nome) && !empty($cargo)) {
        $sql = "UPDATE Tbl_Funcionario SET Fun_Nome = :nome, Fun_Cargo = :cargo WHERE Fun_codigo = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cargo', $cargo);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
    }
}

// Excluir Funcionário
if (isset($_POST['excluir_funcionario'])) {
    $codigo = $_POST['codigo_funcionario'];

    $sql = "DELETE FROM Tbl_Funcionario WHERE Fun_codigo = :codigo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();
}

// Alteração de dados de Registro
if (isset($_POST['alterar_registro'])) {
    $codigo = $_POST['codigo_registro'];
    $data = $_POST['data_registro'];
    $hora = $_POST['hora_registro'];

    if (!empty($data) && !empty($hora)) {
        $sql = "UPDATE Tbl_Registros SET Reg_Data = :data, Reg_Hora = :hora WHERE Reg_codigo = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
    }
}

// Excluir Registro
if (isset($_POST['excluir_registro'])) {
    $codigo = $_POST['codigo_registro'];

    $sql = "DELETE FROM Tbl_Registros WHERE Reg_codigo = :codigo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();
}

// Buscar todos os funcionários
$sql_func = "SELECT * FROM Tbl_Funcionario";
$stmt_func = $pdo->query($sql_func);
$funcionarios = $stmt_func->fetchAll(PDO::FETCH_ASSOC);

// Buscar todos os registros
$sql_reg = "SELECT * FROM Tbl_Registros";
$stmt_reg = $pdo->query($sql_reg);
$registros = $stmt_reg->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alteração de Funcionários e Registros</title>
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

    <!-- Container principal -->
    <div class="container">
        
        <!-- Alteração de Funcionário -->
        <div class="tabela">
            <h2>Alterar ou Excluir Funcionário</h2>
            <form method="POST">
                <label for="codigo_funcionario">Código do Funcionário:</label>
                <input type="number" name="codigo_funcionario" placeholder="Código" required>
                <label for="nome_funcionario">Novo Nome:</label>
                <input type="text" name="nome_funcionario" placeholder="Novo Nome" required>
                <label for="cargo_funcionario">Novo Cargo:</label>
                <input type="text" name="cargo_funcionario" placeholder="Novo Cargo" required>
                <button type="submit" name="alterar_funcionario">Alterar Funcionário</button>
                <button type="submit" name="excluir_funcionario">Excluir Funcionário</button>
            </form>
            
            <h3>Funcionários Cadastrados</h3>
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
        </div>

        <!-- Alteração de Registro -->
        <div class="tabela">
            <h2>Alterar ou Excluir Registro</h2>
            <form method="POST">
                <label for="codigo_registro">Código do Registro:</label>
                <input type="number" name="codigo_registro" placeholder="Código do Registro" required>
                <label for="data_registro">Nova Data:</label>
                <input type="text" name="data_registro" placeholder="Nova Data" required>
                <label for="hora_registro">Nova Hora:</label>
                <input type="text" name="hora_registro" placeholder="Nova Hora" required>
                <button type="submit" name="alterar_registro">Alterar Registro</button>
                <button type="submit" name="excluir_registro">Excluir Registro</button>
            </form>

            <h3>Registros</h3>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Código do Funcionário</th>
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
        </div>

    </div>

</body>
</html>
