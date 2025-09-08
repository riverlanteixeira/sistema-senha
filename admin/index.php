<?php
// Página de administração - Listagem de guichês
include '../includes/conexao_db.php';
include '../includes/shadcn_components.php';
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Sistema de Senhas</title>
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
        .tabs {
            display: flex;
            border-bottom: 1px solid hsl(var(--border));
            margin-bottom: 1rem;
        }
        .tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }
        .tab.active {
            border-bottom: 2px solid hsl(var(--primary));
            color: hsl(var(--primary));
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
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
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: calc(var(--radius) - 2px);
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            cursor: pointer;
            padding: 0.5rem 1rem;
            height: 2.5rem;
        }
        .btn-primary {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
        }
        .btn-primary:hover {
            background-color: hsl(var(--primary) / 0.9);
        }
        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }
        .btn-warning:hover {
            background-color: #d97706;
        }
        .btn-success {
            background-color: #10b981;
            color: white;
        }
        .btn-success:hover {
            background-color: #059669;
        }
        .btn-danger {
            background-color: hsl(var(--destructive));
            color: hsl(var(--destructive-foreground));
        }
        .btn-danger:hover {
            background-color: hsl(var(--destructive) / 0.9);
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            height: 2rem;
            font-size: 0.8125rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .form-control {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: hsl(var(--foreground));
            background-color: hsl(var(--background));
            background-clip: padding-box;
            border: 1px solid hsl(var(--input));
            border-radius: calc(var(--radius) - 2px);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control:focus {
            border-color: hsl(var(--primary));
            outline: 0;
            box-shadow: 0 0 0 3px hsl(var(--primary) / 0.25);
        }
        .alert {
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .d-grid {
            display: grid;
            gap: 0.5rem;
        }
        .gap-2 {
            gap: 0.5rem;
        }
        .mb-4 {
            margin-bottom: 1rem;
        }
        .mt-4 {
            margin-top: 1rem;
        }
        .d-flex {
            display: flex;
        }
        .align-items-end {
            align-items: flex-end;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Administração do Sistema de Senhas</h1>
        </div>
    </div>
    
    <div class="container">
        <!-- Mensagens de feedback -->
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo_mensagem'] == 'success' ? 'success' : 'danger'; ?>">
                <?php echo $_SESSION['mensagem']; ?>
                <?php 
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Abas de navegação -->
        <div class="tabs">
            <div class="tab active" onclick="showTab('guiches')">Gerenciar Guichês</div>
            <div class="tab" onclick="showTab('senhas')">Configurar Senhas</div>
        </div>
        
        <!-- Conteúdo das abas -->
        <div id="guiches" class="tab-content active">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Lista de Guichês</h2>
                </div>
                <div class="card-content">
                    <?php
                    // Obter todos os guichês do banco de dados
                    $sql = "SELECT * FROM guiches ORDER BY id";
                    $result = $conn->query($sql);
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["nome"] . "</td>";
                                    echo "<td>" . ($row["status"] == 1 ? shadcn_badge("Ativo", "secondary") : shadcn_badge("Inativo", "outline")) . "</td>";
                                    echo "<td>";
                                    if ($row["status"] == 1) {
                                        echo shadcn_button("Desativar", "warning", "sm", "", "acao_guiche.php?acao=desativar&id=" . $row["id"]);
                                    } else {
                                        echo shadcn_button("Ativar", "success", "sm", "", "acao_guiche.php?acao=ativar&id=" . $row["id"]);
                                    }
                                    echo " " . shadcn_button("Excluir", "danger", "sm", "", "acao_guiche.php?acao=excluir&id=" . $row["id"], "return confirm('Tem certeza que deseja excluir este guichê?')");
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Nenhum guichê cadastrado</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    
                    <!-- Formulário para adicionar novo guichê -->
                    <form method="POST" action="acao_guiche.php" class="mt-4">
                        <input type="hidden" name="acao" value="adicionar">
                        <div class="grid">
                            <div>
                                <div class="form-group">
                                    <label for="nome_guiche" class="form-label">Nome do Guichê</label>
                                    <input type="text" class="form-control" id="nome_guiche" name="nome_guiche" required>
                                </div>
                            </div>
                            <div class="d-flex align-items-end">
                                <div class="form-group">
                                    <?php echo shadcn_button("Adicionar Guichê", "primary"); ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div id="senhas" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Configuração de Faixas de Senhas</h2>
                </div>
                <div class="card-content">
                    <!-- Botão de reset de senhas -->
                    <div class="alert alert-warning">
                        <h3>Reset de Senhas</h3>
                        <p>Esta ação irá apagar todo o histórico de senhas chamadas. Use com cuidado!</p>
                        <form method="POST" action="acao_reset.php" onsubmit="return confirm('Tem certeza que deseja resetar todas as senhas? Esta ação não pode ser desfeita.')">
                            <input type="hidden" name="acao" value="resetar_senhas">
                            <?php echo shadcn_button("Resetar Todas as Senhas", "destructive"); ?>
                        </form>
                    </div>
                    
                    <!-- Formulário para configurar senhas normais -->
                    <form method="POST" action="acao_senhas.php" class="mb-4">
                        <input type="hidden" name="tipo" value="normal">
                        <div class="grid">
                            <div>
                                <h3>Senhas Normais</h3>
                                <div class="form-group">
                                    <label for="inicial_normal" class="form-label">Número Inicial</label>
                                    <input type="number" class="form-control" id="inicial_normal" name="inicial_normal" min="1" value="1">
                                </div>
                                <div class="form-group">
                                    <label for="final_normal" class="form-label">Número Final</label>
                                    <input type="number" class="form-control" id="final_normal" name="final_normal" min="1" value="100">
                                </div>
                                <div class="form-group">
                                    <?php echo shadcn_button("Salvar Configuração - Normal", "primary"); ?>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Formulário para configurar senhas preferenciais -->
                    <form method="POST" action="acao_senhas.php">
                        <input type="hidden" name="tipo" value="preferencial">
                        <div class="grid">
                            <div>
                                <h3>Senhas Preferenciais</h3>
                                <div class="form-group">
                                    <label for="inicial_preferencial" class="form-label">Número Inicial</label>
                                    <input type="number" class="form-control" id="inicial_preferencial" name="inicial_preferencial" min="1" value="1">
                                </div>
                                <div class="form-group">
                                    <label for="final_preferencial" class="form-label">Número Final</label>
                                    <input type="number" class="form-control" id="final_preferencial" name="final_preferencial" min="1" value="100">
                                </div>
                                <div class="form-group">
                                    <?php echo shadcn_button("Salvar Configuração - Preferencial", "primary"); ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Esconder todas as abas
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remover classe active de todas as tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Mostrar a aba selecionada
            document.getElementById(tabName).classList.add('active');
            
            // Adicionar classe active à tab clicada
            event.target.classList.add('active');
        }
    </script>
</body>
</html>