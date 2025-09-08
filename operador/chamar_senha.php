<?php
// Lógica para chamar a próxima senha
include '../includes/conexao_db.php';
include '../includes/funcoes.php';

$tipo = $_GET['tipo'] ?? '';
$guiche_id = $_GET['guiche'] ?? $_SESSION['guiche_id'] ?? null;

// Verificar se o guiche_id é válido
if (!$guiche_id || $guiche_id <= 0) {
    error_log("Guiche ID inválido: " . $guiche_id);
    header("Location: index.php");
    exit();
}

// Salvar o guichê na sessão
session_start();
$_SESSION['guiche_id'] = $guiche_id;

if (!empty($tipo) && ($tipo == 'normal' || $tipo == 'preferencial')) {
    // Obter a próxima senha disponível
    $proxima_senha = obterProximaSenha($conn, $tipo);
    
    if ($proxima_senha !== null) {
        error_log("Próxima senha obtida: " . $tipo . " " . $proxima_senha);
        
        // Registrar a chamada da senha
        if (registrarChamadaSenha($conn, $tipo, $proxima_senha, $guiche_id)) {
            error_log("Senha registrada com sucesso: " . $tipo . " " . $proxima_senha);
            // Senha chamada com sucesso
            // Em uma implementação real, aqui poderia ter um redirecionamento com mensagem de sucesso
        } else {
            error_log("Erro ao registrar a senha: " . $tipo . " " . $proxima_senha);
            // Erro ao registrar a chamada
            // Em uma implementação real, aqui poderia ter um redirecionamento com mensagem de erro
        }
    } else {
        error_log("Não há mais senhas disponíveis para o tipo: " . $tipo);
        // Não há mais senhas disponíveis
        // Em uma implementação real, aqui poderia ter um redirecionamento com mensagem de aviso
    }
} else {
    error_log("Tipo de senha inválido: " . $tipo);
    // Tipo de senha inválido
    // Em uma implementação real, aqui poderia ter um redirecionamento com mensagem de erro
}

// Redireciona de volta para a página do operador
header("Location: index.php?guiche=" . $guiche_id);
exit();
?>