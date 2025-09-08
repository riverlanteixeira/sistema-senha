<?php
// Interface do operador de guichê
include '../includes/conexao_db.php';

// Obter o ID do guichê da URL ou da sessão
$guiche_id = $_GET['guiche'] ?? $_SESSION['guiche_id'] ?? null;

// Se não houver guichê selecionado, redirecionar para a página de seleção
if (!$guiche_id) {
    header("Location: selecionar_guiche.php");
    exit();
}

// Salvar o guichê na sessão
session_start();
$_SESSION['guiche_id'] = $guiche_id;

// Obter informações do guichê selecionado
$sql = "SELECT * FROM guiches WHERE id = ? AND status = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $guiche_id);
$stmt->execute();
$result_guiche = $stmt->get_result();

if ($result_guiche->num_rows == 0) {
    // Guichê inválido ou inativo
    header("Location: selecionar_guiche.php");
    exit();
}

$guiche = $result_guiche->fetch_assoc();
$stmt->close();

// Obter todos os guichês ativos para o menu
$sql = "SELECT * FROM guiches WHERE status = 1 ORDER BY id";
$result = $conn->query($sql);

// Obter a última senha chamada por este guichê
$ultima_senha = "Nenhuma senha chamada";

$sql = "SELECT tipo_senha, numero_senha FROM senhas_chamadas WHERE guiche_id = ? ORDER BY data_hora DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $guiche_id);
$stmt->execute();
$result_senha = $stmt->get_result();

if ($result_senha->num_rows > 0) {
    $row = $result_senha->fetch_assoc();
    $ultima_senha = strtoupper(substr($row['tipo_senha'], 0, 1)) . " " . $row['numero_senha'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operador - Sistema de Senhas</title>
    <link href="../assets/css/estilo.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <img src="../logo-pcsc.png" alt="Logo PCSC" class="logo-pcsc">
                <div>
                    <h1 class="header-title">POLÍCIA CIVIL DE SANTA CATARINA</h1>
                    <p class="header-subtitle">Painel do Operador - Guichê <?php echo $guiche['nome']; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <!-- Menu de seleção de guichê -->
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">Guichê Selecionado</h2>
            </div>
            <div class="card-content">
                <div class="grid">
                    <div>
                        <p><strong>Guichê:</strong> <?php echo $guiche['nome']; ?></p>
                        <p><strong>Última senha chamada:</strong> <?php echo $ultima_senha; ?></p>
                    </div>
                    <div class="text-center">
                        <a href="selecionar_guiche.php" class="btn btn-secondary">Mudar Guichê</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Chamar Próxima Senha</h2>
                </div>
                <div class="card-content">
                    <div class="d-grid">
                        <a href="chamar_senha.php?tipo=normal&guiche=<?php echo $guiche_id; ?>" class="btn btn-primary">Chamar Próxima Normal</a>
                        <a href="chamar_senha.php?tipo=preferencial&guiche=<?php echo $guiche_id; ?>" class="btn btn-primary">Chamar Próxima Preferencial</a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Guichês Ativos</h2>
                </div>
                <div class="card-content">
                    <div class="grid">
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $btn_class = ($row['id'] == $guiche_id) ? 'btn-primary' : 'btn-secondary';
                                echo "<div>";
                                echo "<a href='index.php?guiche=" . $row['id'] . "' class='btn " . $btn_class . " btn-sm'>" . $row['nome'] . "</a>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h2 class="card-title">Histórico de Senhas Chamadas</h2>
            </div>
            <div class="card-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Senha</th>
                            <th>Data/Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obter histórico de senhas chamadas por este guichê
                        $sql = "SELECT tipo_senha, numero_senha, data_hora FROM senhas_chamadas WHERE guiche_id = ? ORDER BY data_hora DESC LIMIT 10";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $guiche_id);
                        $stmt->execute();
                        $result_historico = $stmt->get_result();
                        
                        if ($result_historico->num_rows > 0) {
                            while($row = $result_historico->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . strtoupper(substr($row['tipo_senha'], 0, 1)) . " " . $row['numero_senha'] . "</td>";
                                echo "<td>" . date('d/m/Y H:i:s', strtotime($row['data_hora'])) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Nenhuma senha chamada ainda</td></tr>";
                        }
                        $stmt->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>