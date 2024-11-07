<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>
   
    <!-- Menu de navegação -->
    <div class="menu">
        <a href="menu.php"><button>Menu</button></a> <!-- O botão "Menu" que recarrega a página -->
        <a href="Cadastro.php"><button>Cadastro</button></a>
        <a href="Visualizar.php"><button>Visualizar</button></a>
        <a href="Alterar.php"><button>Alteração</button></a>
        <a href="cadastro_funcionario.php"><button>Cadastrar Registros</button></a> <!-- Novo botão -->
    </div>

   
    <object data="hack.jfif" type="image/jpeg" width="500" height="300">
    Seu navegador não suporta objetos embutidos.
</object>


    <!-- Conteúdo do banco de dados -->
    <div class="database">
        <h1>Banco de Dados Empresa</h1>

        <!-- Exibição das tabelas -->
        <div class="table">
            <h2>Tabela: Tbl_Funcionario</h2>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Cargo</th>
                    </tr>
                </thead>
                <tbody>
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

                    // Exibir os dados de Tbl_Funcionario
                    foreach ($funcionarios as $funcionario) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($funcionario['Fun_codigo']) . "</td>";
                        echo "<td>" . htmlspecialchars($funcionario['Fun_Nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($funcionario['Fun_Cargo']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Exibição da Tabela: Tbl_Registros -->
        <div class="table">
            <h2>Tabela: Tbl_Registros</h2>
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
                    <?php
                    // Buscar dados da tabela Tbl_Registros
                    $sql_reg = "SELECT * FROM Tbl_Registros";
                    $stmt_reg = $pdo->query($sql_reg);
                    $registros = $stmt_reg->fetchAll(PDO::FETCH_ASSOC);

                    // Exibir os dados de Tbl_Registros
                    foreach ($registros as $registro) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($registro['Reg_codigo']) . "</td>";
                        echo "<td>" . htmlspecialchars($registro['Reg_Data']) . "</td>";
                        echo "<td>" . htmlspecialchars($registro['Reg_Hora']) . "</td>";
                        echo "<td>" . htmlspecialchars($registro['Fun_codigo']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
