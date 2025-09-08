<?php
// Ação para resetar as senhas chamadas
include '../includes/conexao_db.php';
session_start();

// Verificar se a ação é válida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'resetar_senhas') {
    // Resetar todas as senhas chamadas
    $sql = "DELETE FROM senhas_chamadas";
    
    if ($conn->query($sql)) {
        $_SESSION['mensagem'] = "Todas as senhas foram resetadas com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao resetar as senhas: " . $conn->error;
        $_SESSION['tipo_mensagem'] = "error";
    }
} else {
    $_SESSION['mensagem'] = "Ação inválida.";
    $_SESSION['tipo_mensagem'] = "error";
}

// Redireciona de volta para a página de administração
header("Location: index.php");
exit();
?>