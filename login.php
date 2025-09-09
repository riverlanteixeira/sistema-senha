<?php
// Página de login
session_start();

// Se o usuário já estiver logado, redireciona para a área apropriada
if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['nivel'] == 'admin') {
        header("Location: admin/");
        exit();
    } else {
        header("Location: operador/");
        exit();
    }
}

$erro = "";
$login_valor = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_valor = trim($_POST['login'] ?? '');
    $senha_valor = trim($_POST['senha'] ?? '');
    
    if (empty($login_valor) || empty($senha_valor)) {
        $erro = "Preencha todos os campos.";
    } else {
        // Incluir conexão com o banco de dados
        include 'includes/conexao_db.php';
        
        // Preparar e executar a consulta
        $stmt = $conn->prepare("SELECT id, nome, login, senha, nivel FROM usuarios WHERE login = ? AND ativo = 1");
        $stmt->bind_param("s", $login_valor);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            
            // Verificar a senha
            if ($senha_valor === $usuario['senha']) {
                // Login bem-sucedido - definir variáveis de sessão
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['nivel'] = $usuario['nivel'];
                $_SESSION['login'] = $usuario['login'];
                
                // Redirecionar com base no nível do usuário
                if ($usuario['nivel'] == 'admin') {
                    header("Location: admin/");
                    exit();
                } else {
                    header("Location: operador/");
                    exit();
                }
            } else {
                $erro = "Login ou senha incorretos.";
            }
        } else {
            $erro = "Login ou senha incorretos.";
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Senhas</title>
    <link href="assets/css/estilo.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <img src="logo-pcsc.png" alt="Logo PCSC" class="logo-pcsc">
                <div>
                    <h1 class="header-title">POLÍCIA CIVIL DE SANTA CATARINA</h1>
                    <p class="header-subtitle">Sistema de Gerenciamento de Senhas de Atendimento</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Acesso ao Sistema</h2>
                </div>
                <div class="card-content">
                    <?php if (!empty($erro)): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="form-group">
                            <label for="login" class="form-label">Login</label>
                            <input type="text" class="form-control" id="login" name="login" required value="<?php echo htmlspecialchars($login_valor); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .login-container {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
    </style>
</body>
</html>