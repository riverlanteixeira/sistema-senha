<?php
// Ações relacionadas às configurações de senhas
include '../includes/conexao_db.php';
session_start();

// Log de depuração
error_log("=== Iniciando acao_senhas.php ===");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Método POST detectado");
    error_log("Dados POST recebidos: " . print_r($_POST, true));
    
    $tipo = $_POST['tipo'] ?? '';
    $inicial = $_POST['inicial_' . $tipo] ?? 0;
    $final = $_POST['final_' . $tipo] ?? 0;
    
    // Converter para inteiros
    $inicial = (int)$inicial;
    $final = (int)$final;
    
    error_log("Dados extraídos - Tipo: '$tipo', Inicial: $inicial, Final: $final");
    
    if (!empty($tipo) && $inicial > 0 && $final > 0) {
        error_log("Dados válidos, prosseguindo com o salvamento");
        
        // Verifica se já existe configuração para este tipo de senha
        $sql = "SELECT id FROM configuracoes WHERE tipo_senha = ?";
        error_log("Executando consulta: $sql com parâmetro: $tipo");
        
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $tipo);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                error_log("Consulta executada, registros encontrados: " . $result->num_rows);
                
                if ($result->num_rows > 0) {
                    // Atualiza a configuração existente
                    $row = $result->fetch_assoc();
                    $sql = "UPDATE configuracoes SET numero_inicial = ?, numero_final = ? WHERE id = ?";
                    error_log("Atualizando configuração existente - ID: " . $row['id']);
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("iii", $inicial, $final, $row['id']);
                        if ($stmt->execute()) {
                            error_log("Configuração atualizada com sucesso");
                            $_SESSION['mensagem'] = "Configuração de senhas " . $tipo . " atualizada com sucesso!";
                            $_SESSION['tipo_mensagem'] = "success";
                        } else {
                            error_log("Erro ao atualizar configuração: " . $stmt->error);
                            $_SESSION['mensagem'] = "Erro ao atualizar a configuração de senhas " . $tipo . ".";
                            $_SESSION['tipo_mensagem'] = "error";
                        }
                    } else {
                        error_log("Erro ao preparar statement de atualização: " . $conn->error);
                        $_SESSION['mensagem'] = "Erro ao preparar atualização de configuração.";
                        $_SESSION['tipo_mensagem'] = "error";
                    }
                } else {
                    // Insere nova configuração
                    $sql = "INSERT INTO configuracoes (tipo_senha, numero_inicial, numero_final) VALUES (?, ?, ?)";
                    error_log("Inserindo nova configuração");
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("sii", $tipo, $inicial, $final);
                        if ($stmt->execute()) {
                            error_log("Nova configuração inserida com sucesso");
                            $_SESSION['mensagem'] = "Configuração de senhas " . $tipo . " salva com sucesso!";
                            $_SESSION['tipo_mensagem'] = "success";
                        } else {
                            error_log("Erro ao inserir configuração: " . $stmt->error);
                            $_SESSION['mensagem'] = "Erro ao salvar a configuração de senhas " . $tipo . ".";
                            $_SESSION['tipo_mensagem'] = "error";
                        }
                    } else {
                        error_log("Erro ao preparar statement de inserção: " . $conn->error);
                        $_SESSION['mensagem'] = "Erro ao preparar inserção de configuração.";
                        $_SESSION['tipo_mensagem'] = "error";
                    }
                }
                $stmt->close();
            } else {
                error_log("Erro ao executar consulta: " . $stmt->error);
                $_SESSION['mensagem'] = "Erro ao verificar configuração existente.";
                $_SESSION['tipo_mensagem'] = "error";
            }
        } else {
            error_log("Erro ao preparar statement: " . $conn->error);
            $_SESSION['mensagem'] = "Erro ao preparar consulta.";
            $_SESSION['tipo_mensagem'] = "error";
        }
    } else {
        error_log("Dados inválidos");
        $_SESSION['mensagem'] = "Dados inválidos. Certifique-se de que todos os campos estão preenchidos corretamente.";
        $_SESSION['tipo_mensagem'] = "error";
    }
} else {
    error_log("Método não é POST");
    $_SESSION['mensagem'] = "Método de requisição inválido.";
    $_SESSION['tipo_mensagem'] = "error";
}

error_log("Redirecionando para index.php");
// Redireciona de volta para a página de administração
header("Location: index.php");
exit();
?>