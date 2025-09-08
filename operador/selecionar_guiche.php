<?php
// Página de seleção de guichê para o operador
include '../includes/conexao_db.php';

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
            <h1>Seleção de Guichê</h1>
        </div>
    </div>
    
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
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .header {
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 1rem 0;
            margin-bottom: 2rem;
            text-align: center;
        }
        .w-100 {
            width: 100%;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeaa7;
        }
    </style>
</body>
</html>