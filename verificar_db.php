<?php
// Script para verificar se o banco de dados existe e está configurado corretamente
$host = 'localhost';
$usuario = 'root';
$senha = '';

// Conectar ao MySQL
$conn = new mysqli($host, $usuario, $senha);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

echo "<h1>Verificação do Banco de Dados</h1>\n";

// Verificar se o banco de dados 'senhas_atendimento' existe
$sql = "SHOW DATABASES LIKE 'senhas_atendimento'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p style='color: green;'>✓ Banco de dados 'senhas_atendimento' existe</p>\n";
    
    // Selecionar o banco de dados
    $conn->select_db('senhas_atendimento');
    
    // Verificar as tabelas
    $tabelas = ['guiches', 'configuracoes', 'senhas_chamadas'];
    foreach ($tabelas as $tabela) {
        $sql = "SHOW TABLES LIKE '$tabela'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>✓ Tabela '$tabela' existe</p>\n";
        } else {
            echo "<p style='color: red;'>✗ Tabela '$tabela' não existe</p>\n";
        }
    }
} else {
    echo "<p style='color: red;'>✗ Banco de dados 'senhas_atendimento' não existe</p>\n";
}

$conn->close();
?>