<?php
// Script para verificar detalhadamente o banco de dados
include '../includes/conexao_db.php';

echo "<h1>Verificação Detalhada do Banco de Dados</h1>\n";

// Verificar se a conexão foi estabelecida
if ($conn->connect_error) {
    echo "<p style='color: red;'>Erro de conexão: " . $conn->connect_error . "</p>\n";
    exit;
} else {
    echo "<p style='color: green;'>Conexão estabelecida com sucesso.</p>\n";
}

// Verificar se o banco de dados existe
$sql = "SHOW DATABASES LIKE 'senhas_atendimento'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<p style='color: green;'>Banco de dados 'senhas_atendimento' existe.</p>\n";
} else {
    echo "<p style='color: red;'>Banco de dados 'senhas_atendimento' NÃO existe.</p>\n";
}

// Selecionar o banco de dados
if ($conn->select_db('senhas_atendimento')) {
    echo "<p style='color: green;'>Banco de dados selecionado com sucesso.</p>\n";
} else {
    echo "<p style='color: red;'>Erro ao selecionar banco de dados: " . $conn->error . "</p>\n";
}

// Verificar se a tabela configuracoes existe
$sql = "SHOW TABLES LIKE 'configuracoes'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<p style='color: green;'>Tabela 'configuracoes' existe.</p>\n";
} else {
    echo "<p style='color: red;'>Tabela 'configuracoes' NÃO existe.</p>\n";
}

// Verificar a estrutura da tabela configuracoes
$sql = "DESCRIBE configuracoes";
$result = $conn->query($sql);
if ($result) {
    echo "<h2>Estrutura da tabela 'configuracoes':</h2>\n";
    echo "<table border='1'>\n";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>\n";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p style='color: red;'>Erro ao descrever tabela 'configuracoes': " . $conn->error . "</p>\n";
}

// Testar inserção manual
echo "<h2>Teste de inserção manual:</h2>\n";
$sql = "INSERT INTO configuracoes (tipo_senha, numero_inicial, numero_final) VALUES ('teste', 1, 10)";
if ($conn->query($sql)) {
    echo "<p style='color: green;'>Inserção de teste bem-sucedida. ID: " . $conn->insert_id . "</p>\n";
    
    // Verificar se o registro foi inserido
    $sql = "SELECT * FROM configuracoes WHERE tipo_senha = 'teste'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>Registro encontrado na tabela.</p>\n";
        $row = $result->fetch_assoc();
        echo "<pre>\n";
        print_r($row);
        echo "</pre>\n";
    } else {
        echo "<p style='color: red;'>Registro NÃO encontrado na tabela.</p>\n";
    }
    
    // Limpar o registro de teste
    $sql = "DELETE FROM configuracoes WHERE tipo_senha = 'teste'";
    $conn->query($sql);
} else {
    echo "<p style='color: red;'>Erro na inserção de teste: " . $conn->error . "</p>\n";
}

$conn->close();
?>