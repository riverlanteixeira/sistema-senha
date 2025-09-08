<?php
// Ações relacionadas aos guichês (adicionar, ativar, desativar, excluir)
include '../includes/conexao_db.php';

// Iniciar sessão para mensagens de feedback
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    switch ($acao) {
        case 'adicionar':
            $nome = $_POST['nome_guiche'] ?? '';
            if (!empty($nome)) {
                $sql = "INSERT INTO guiches (nome, status) VALUES (?, 1)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $nome);
                $stmt->execute();
                $stmt->close();
            }
            break;
    }
} else {
    // Ações via GET
    $acao = $_GET['acao'] ?? '';
    $id = $_GET['id'] ?? 0;
    
    switch ($acao) {
        case 'ativar':
            $sql = "UPDATE guiches SET status = 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            break;
            
        case 'desativar':
            $sql = "UPDATE guiches SET status = 0 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            break;
            
        case 'excluir':
            // Verificar se o guichê existe
            $sql = "SELECT COUNT(*) as total FROM guiches WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['total'] > 0) {
                // Verificar se há senhas associadas
                $sql = "SELECT COUNT(*) as total FROM senhas_chamadas WHERE guiche_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                
                if ($row['total'] == 0) {
                    // Não há senhas associadas, pode excluir
                    $sql = "DELETE FROM guiches WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) {
                        $_SESSION['mensagem'] = "Guichê excluído com sucesso!";
                        $_SESSION['tipo_mensagem'] = "success";
                    } else {
                        $_SESSION['mensagem'] = "Erro ao excluir o guichê.";
                        $_SESSION['tipo_mensagem'] = "error";
                    }
                    $stmt->close();
                } else {
                    // Há senhas associadas, não pode excluir
                    $_SESSION['mensagem'] = "Não é possível excluir este guichê porque ele possui senhas associadas.";
                    $_SESSION['tipo_mensagem'] = "error";
                }
            } else {
                // Guichê não encontrado
                $_SESSION['mensagem'] = "Guichê não encontrado.";
                $_SESSION['tipo_mensagem'] = "error";
            }
            break;
    }
}

// Redireciona de volta para a página de administração
header("Location: index.php");
exit();
?>