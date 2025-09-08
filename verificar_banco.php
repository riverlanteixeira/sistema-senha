<?php
// Script para verificar a estrutura do banco de dados
include 'includes/conexao_db.php';

// Verificar se as tabelas existem
$tabelas = ['guiches', 'configuracoes', 'senhas_chamadas'];
$resultados = [];

foreach ($tabelas as $tabela) {
    $sql = "SHOW TABLES LIKE '$tabela'";
    $result = $conn->query($sql);
    $resultados[$tabela] = $result->num_rows > 0;
}

echo "<h1>Verificação da Estrutura do Banco de Dados</h1>\n";

foreach ($resultados as $tabela => $existe) {
    if ($existe) {
        echo "<p style='color: green;'>✓ Tabela '$tabela' existe</p>\n";
        
        // Mostrar a estrutura da tabela
        $sql = "DESCRIBE $tabela";
        $result = $conn->query($sql);
        echo "<pre>\n";
        while($row = $result->fetch_assoc()) {
            print_r($row);
        }
        echo "</pre>\n";
    } else {
        echo "<p style='color: red;'>✗ Tabela '$tabela' não existe</p>\n";
    }
}

// Verificar dados de exemplo
echo "<h2>Dados de Exemplo</h2>\n";

foreach ($tabelas as $tabela) {
    $sql = "SELECT * FROM $tabela LIMIT 5";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<h3>Tabela: $tabela</h3>\n";
        echo "<pre>\n";
        while($row = $result->fetch_assoc()) {
            print_r($row);
        }
        echo "</pre>\n";
    } else {
        echo "<p>Tabela '$tabela' está vazia</p>\n";
    }
}

$conn->close();
?>