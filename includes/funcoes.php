<?php
// Funções auxiliares do sistema

// Função para obter a próxima senha disponível
function obterProximaSenha($conn, $tipo) {
    // Obter a configuração de senhas para o tipo especificado
    $sql = "SELECT numero_inicial, numero_final FROM configuracoes WHERE tipo_senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $config = $result->fetch_assoc();
        $inicial = $config['numero_inicial'];
        $final = $config['numero_final'];
        
        // Obter a última senha chamada deste tipo
        $sql = "SELECT MAX(numero_senha) as ultima FROM senhas_chamadas WHERE tipo_senha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $proxima_senha = $inicial;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['ultima'] !== null) {
                $proxima_senha = $row['ultima'] + 1;
            }
        }
        
        // Verificar se a próxima senha está dentro da faixa configurada
        if ($proxima_senha <= $final) {
            return $proxima_senha;
        }
    }
    
    return null; // Nenhuma senha disponível
}

// Função para registrar a chamada de uma senha
function registrarChamadaSenha($conn, $tipo, $numero, $guiche_id) {
    $sql = "INSERT INTO senhas_chamadas (tipo_senha, numero_senha, guiche_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $tipo, $numero, $guiche_id);
    
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    }
    
    $stmt->close();
    return false;
}

// Função para obter as últimas senhas chamadas
function obterUltimasSenhasChamadas($conn, $limite = 5) {
    $sql = "SELECT sc.tipo_senha, sc.numero_senha, g.nome as guiche_nome, sc.data_hora 
            FROM senhas_chamadas sc 
            JOIN guiches g ON sc.guiche_id = g.id 
            ORDER BY sc.data_hora DESC 
            LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limite);
    
    if (!$stmt->execute()) {
        error_log("Erro ao executar consulta: " . $stmt->error);
        $stmt->close();
        return [];
    }
    
    $result = $stmt->get_result();
    
    $senhas = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $senhas[] = $row;
        }
    }
    
    $stmt->close();
    return $senhas;
}
?>