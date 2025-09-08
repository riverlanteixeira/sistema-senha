<?php
// Script para inserir uma configuração de teste
include '../includes/conexao_db.php';

echo "<h1>Inserindo Configuração de Teste</h1>\n";

// Inserir configuração de teste para senhas normais
$sql = "INSERT INTO configuracoes (tipo_senha, numero_inicial, numero_final) VALUES ('normal', 1, 100)";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>Configuração de senhas normais inserida com sucesso!</p>\n";
} else {
    echo "<p style='color: red;'>Erro ao inserir configuração de senhas normais: " . $conn->error . "</p>\n";
}

// Inserir configuração de teste para senhas preferenciais
$sql = "INSERT INTO configuracoes (tipo_senha, numero_inicial, numero_final) VALUES ('preferencial', 1, 50)";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>Configuração de senhas preferenciais inserida com sucesso!</p>\n";
} else {
    echo "<p style='color: red;'>Erro ao inserir configuração de senhas preferenciais: " . $conn->error . "</p>\n";
}

$conn->close();

echo "<p><a href='verificar_config.php'>Verificar configurações</a></p>\n";
?>