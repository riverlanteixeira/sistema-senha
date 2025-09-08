<?php
// Script para testar o reset de senhas
include '../includes/conexao_db.php';

echo "<h1>Teste de Reset de Senhas</h1>\n";

// Verificar senhas antes do reset
$sql = "SELECT COUNT(*) as total FROM senhas_chamadas";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_antes = $row['total'];

echo "<p>Senhas antes do reset: " . $total_antes . "</p>\n";

if ($total_antes > 0) {
    // Executar reset
    $sql = "DELETE FROM senhas_chamadas";
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>Reset executado com sucesso!</p>\n";
        
        // Verificar senhas após o reset
        $sql = "SELECT COUNT(*) as total FROM senhas_chamadas";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_depois = $row['total'];
        
        echo "<p>Senhas após o reset: " . $total_depois . "</p>\n";
        
        if ($total_depois == 0) {
            echo "<p style='color: green;'>Reset confirmado: todas as senhas foram removidas.</p>\n";
        } else {
            echo "<p style='color: red;'>Erro: ainda há senhas no sistema.</p>\n";
        }
    } else {
        echo "<p style='color: red;'>Erro ao executar reset: " . $conn->error . "</p>\n";
    }
} else {
    echo "<p>Não há senhas para resetar.</p>\n";
}

$conn->close();

echo "<p><a href='teste_funcionalidades.php'>Voltar</a></p>\n";
?>
