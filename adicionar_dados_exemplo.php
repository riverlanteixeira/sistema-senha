<?php
// Adicionar dados de exemplo para testes
include 'includes/conexao_db.php';

// Adicionar alguns guichês de exemplo
$sql = "INSERT INTO guiches (nome, status) VALUES ('Guichê 1', 1), ('Guichê 2', 1), ('Caixa', 1)";
$conn->query($sql);

// Adicionar configurações de senhas de exemplo
$sql = "INSERT INTO configuracoes (tipo_senha, numero_inicial, numero_final) VALUES ('normal', 1, 100), ('preferencial', 1, 50)";
$conn->query($sql);

echo "Dados de exemplo adicionados com sucesso!";
?>