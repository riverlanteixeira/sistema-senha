<?php
// Página de seleção de guichê para o operador
include '../includes/autenticacao.php';
include '../includes/conexao_db.php';

// Verificar se o usuário está autenticado (qualquer usuário autenticado pode acessar)
verificarAutenticacao();

// Obter todos os guichês ativos
$sql = "SELECT * FROM guiches WHERE status = 1 ORDER BY id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção de Guichê - Sistema de Senhas</title>
    <link href="../assets/css/estilo.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <img src="../logo-pcsc.png" alt="Logo PCSC" class="logo-pcsc">
                <div>
                    <h1 class="header-title">POLÍCIA CIVIL DE SANTA CATARINA</h1>
                    <p class="header-subtitle">Seleção de Guichê</p>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/menu_navegacao.php'; ?>
    
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Selecione o guichê que você irá operar</h2>
            </div>
            <div class="card-content">
                <?php if ($result->num_rows > 0): ?>
                    <div class="grid">
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div>
                                <a href="index.php?guiche=<?php echo $row['id']; ?>" class="btn btn-primary w-100"><?php echo $row['nome']; ?></a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <p>Nenhum guichê ativo encontrado. Por favor, contate o administrador.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>