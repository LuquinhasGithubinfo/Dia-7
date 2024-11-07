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

// Buscar dados da tabela Tbl_Funcionario
$sql_func = "SELECT * FROM Tbl_Funcionario";
$stmt_func = $pdo->query($sql_func);
$funcionarios = $stmt_func->fetchAll(PDO::FETCH_ASSOC);

// Buscar dados da tabela Tbl_Registros
$sql_reg = "SELECT * FROM Tbl_Registros";
$stmt_reg = $pdo->query($sql_reg);
$registros = $stmt_reg->fetchAll(PDO::FETCH_ASSOC);

// Inserir um novo registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['funcionario_id']) && isset($_POST['data']) && isset($_POST['hora'])) {
    $funcionario_id = $_POST['funcionario_id'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    // Inserir o novo registro na tabela Tbl_Registros
    $sql_insert = "INSERT INTO Tbl_Registros (Fun_codigo, Reg_Data, Reg_Hora) VALUES (:funcionario_id, :data, :hora)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindParam(':funcionario_id', $funcionario_id);
    $stmt_insert->bindParam(':data', $data);
    $stmt_insert->bindParam(':hora', $hora);
    $stmt_insert->execute();
    
    // Redireciona para evitar reenvio do formulário
    header("Location: cadastro_funcionario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Registros</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>
   
    <!-- Menu de navegação -->
    <div class="menu">
        <a href="menu.php"><button>Menu</button></a> <!-- O botão "Menu" que recarrega a página -->
        <a href="Cadastro.php"><button>Cadastro</button></a>
        <a href="Visualizar.php"><button>Visualizar</button></a>
        <a href="Alterar.php"><button>Alteração</button></a>
        <a href="cadastro_funcionario.php"><button>Cadastrar Registros</button></a> <!-- Botão "Cadastrar Registros" -->
    </div>

    <!-- Formulário para Cadastrar Registros -->
    <div class="formulario">
        <h2>Cadastrar Novo Registro</h2>
        <form method="POST">
            <label for="funcionario_id">Funcionário:</label>
            <select name="funcionario_id" required>
                <option value="">Escolha o Funcionário</option>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <option value="<?php echo $funcionario['Fun_codigo']; ?>"><?php echo $funcionario['Fun_Nome']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label for="data">Data:</label>
            <input type="date" name="data" required>
            <br>

            <label for="hora">Hora:</label>
            <input type="time" name="hora" required>
            <br>

            <button type="submit">Cadastrar Registro</button>
        </form>
    </div>

    <!-- Exibição de registros -->
    <div class="table">
        <h2>Registros Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Funcionário</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $registro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($registro['Reg_codigo']); ?></td>
                        <td><?php echo htmlspecialchars($registro['Reg_Data']); ?></td>
                        <td><?php echo htmlspecialchars($registro['Reg_Hora']); ?></td>
                        <td>
                            <?php
                            // Encontrar o nome do funcionário com base no código
                            $funcionario = array_filter($funcionarios, function($f) use ($registro) {
                                return $f['Fun_codigo'] == $registro['Fun_codigo'];
                            });
                            echo htmlspecialchars(current($funcionario)['Fun_Nome']);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
