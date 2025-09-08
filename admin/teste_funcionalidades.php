<?php
// Script para testar as novas funcionalidades
include '../includes/conexao_db.php';

echo "<h1>Teste das Novas Funcionalidades</h1>\n";

// Verificar se há senhas chamadas
$sql = "SELECT COUNT(*) as total FROM senhas_chamadas";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo "<h2>Senhas Chamadas:</h2>\n";
echo "<p>Total de senhas chamadas: " . $row['total'] . "</p>\n";

if ($row['total'] > 0) {
    echo "<p><a href='teste_reset.php' class='btn btn-danger'>Testar Reset de Senhas</a></p>\n";
} else {
    echo "<p>Nenhuma senha chamada para resetar.</p>\n";
}

// Verificar guichês
$sql = "SELECT COUNT(*) as total FROM guiches WHERE status = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo "<h2>Guichês Ativos:</h2>\n";
echo "<p>Total de guichês ativos: " . $row['total'] . "</p>\n";

if ($row['total'] > 0) {
    echo "<p><a href='../operador/selecionar_guiche.php' class='btn btn-primary'>Testar Seleção de Guichê</a></p>\n";
} else {
    echo "<p>Nenhum guichê ativo disponível.</p>\n";
}

$conn->close();
?>