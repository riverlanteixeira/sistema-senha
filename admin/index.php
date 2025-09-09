<?php
// Página de administração - Listagem de guichês
include '../includes/autenticacao.php';
include '../includes/conexao_db.php';

// Verificar se o usuário está autenticado (qualquer usuário autenticado pode acessar)
verificarAutenticacao();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Sistema de Senhas</title>
    <link href="../assets/css/estilo.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <img src="../logo-pcsc.png" alt="Logo PCSC" class="logo-pcsc">
                <div>
                    <h1 class="header-title">POLÍCIA CIVIL DE SANTA CATARINA</h1>
                    <p class="header-subtitle">Sistema de Gerenciamento de Senhas de Atendimento</p>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/menu_navegacao.php'; ?>
    
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
                                    echo "<td>" . ($row["status"] == 1 ? "<span class='badge badge-success'>Ativo</span>" : "<span class='badge badge-secondary'>Inativo</span>") . "</td>";
                                    echo "<td>";
                                    if ($row["status"] == 1) {
                                        echo "<a href='acao_guiche.php?acao=desativar&id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Desativar</a>";
                                    } else {
                                        echo "<a href='acao_guiche.php?acao=ativar&id=" . $row["id"] . "' class='btn btn-success btn-sm'>Ativar</a>";
                                    }
                                    echo " <a href='acao_guiche.php?acao=excluir&id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir este guichê?\")'>Excluir</a>";
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
                        <div class="grid add-guiche-form">
                            <div>
                                <label for="nome_guiche" class="form-label">Nome do Guichê</label>
                                <input type="text" class="form-control" id="nome_guiche" name="nome_guiche" required>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Adicionar Guichê</button>
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
                            <button type="submit" class="btn btn-danger">Resetar Todas as Senhas</button>
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
                                    <button type="submit" class="btn btn-primary">Salvar Configuração - Normal</button>
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
                                    <button type="submit" class="btn btn-primary">Salvar Configuração - Preferencial</button>
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