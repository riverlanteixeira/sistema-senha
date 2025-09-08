<?php
// Script para adicionar um guichê de teste
include '../includes/conexao_db.php';

// Adicionar um guichê de teste
$sql = "INSERT INTO guiches (nome, status) VALUES ('Guichê Teste Exclusão', 1)";
if ($conn->query($sql) === TRUE) {
    echo "Guichê de teste adicionado com sucesso! ID: " . $conn->insert_id;
} else {
    echo "Erro ao adicionar guichê de teste: " . $conn->error;
}

$conn->close();
?>