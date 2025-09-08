<?php
// Interface do operador de guichê
include '../includes/conexao_db.php';
include '../includes/shadcn_components.php';

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
    <link href="../assets/css/shadcn.css" rel="stylesheet">
    <style>
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }
        .header {
            background-color: white;
            border-bottom: 1px solid hsl(var(--border));
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid hsl(var(--border));
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .card-header {
            padding: 1.25rem;
            border-bottom: 1px solid hsl(var(--border));
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }
        .card-content {
            padding: 1.25rem;
        }
        .d-grid {
            display: grid;
            gap: 0.75rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: calc(var(--radius) - 2px);
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.15s ease;
            cursor: pointer;
            padding: 0.75rem 1rem;
            height: 3rem;
            text-decoration: none;
            color: white;
        }
        .btn-primary {
            background-color: hsl(var(--primary));
        }
        .btn-primary:hover {
            background-color: hsl(var(--primary) / 0.9);
        }
        .btn-success {
            background-color: #10b981;
        }
        .btn-success:hover {
            background-color: #059669;
        }
        .btn-secondary {
            background-color: hsl(var(--secondary));
            color: hsl(var(--secondary-foreground));
        }
        .btn-secondary:hover {
            background-color: hsl(var(--secondary) / 0.8);
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid hsl(var(--border));
        }
        .table th {
            font-weight: 600;
            color: hsl(var(--muted-foreground));
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            height: 2rem;
            font-size: 0.8125rem;
        }
        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid hsl(var(--primary));
            color: hsl(var(--primary));
        }
        .btn-outline-primary:hover {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
        }
        .text-center {
            text-align: center;
        }
        .mb-4 {
            margin-bottom: 1rem;
        }
        .mt-4 {
            margin-top: 1rem;
        }
        .alert {
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .alert-warning {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Painel do Operador</h1>
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
                        <?php echo shadcn_button("Mudar Guichê", "secondary", "default", "", "selecionar_guiche.php"); ?>
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
                        <?php echo shadcn_button("Chamar Próxima Normal", "primary", "default", "", "chamar_senha.php?tipo=normal&guiche=" . $guiche_id); ?>
                        <?php echo shadcn_button("Chamar Próxima Preferencial", "success", "default", "", "chamar_senha.php?tipo=preferencial&guiche=" . $guiche_id); ?>
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
                                $btn_variant = ($row['id'] == $guiche_id) ? 'primary' : 'outline-primary';
                                echo "<div>";
                                echo shadcn_button($row['nome'], $btn_variant, "sm", "", "index.php?guiche=" . $row['id']);
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