<?php
// Página de seleção de guichê para o operador
include '../includes/conexao_db.php';
include '../includes/shadcn_components.php';

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
    <link href="../assets/css/shadcn.css" rel="stylesheet">
    <style>
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
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
            border-bottom: 1px solid hsl(var(--border));
            padding: 1rem 0;
            margin-bottom: 2rem;
            text-align: center;
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
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            text-align: center;
        }
        .card-content {
            padding: 1.25rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
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
            text-align: center;
        }
        .btn-primary {
            background-color: hsl(var(--primary));
        }
        .btn-primary:hover {
            background-color: hsl(var(--primary) / 0.9);
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
        .text-center {
            text-align: center;
        }
    </style>
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
                                <?php echo shadcn_button($row['nome'], "primary", "default", "w-100", "index.php?guiche=" . $row['id']); ?>
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