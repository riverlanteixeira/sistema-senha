<?php
// Script para verificar e corrigir possíveis erros no sistema
include 'includes/conexao_db.php';

echo "<h1>Verificação e Correção de Erros do Sistema</h1>\n";

// Verificar se há dados nas tabelas
$tabelas = ['guiches', 'configuracoes', 'senhas_chamadas'];

foreach ($tabelas as $tabela) {
    $sql = "SELECT COUNT(*) as total FROM $tabela";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    echo "<p>Tabela '$tabela': " . $row['total'] . " registros</p>\n";
    
    if ($row['total'] == 0) {
        echo "<p style='color: orange;'>A tabela '$tabela' está vazia. Isso pode ser esperado se ainda não foram adicionados dados.</p>\n";
    }
}

// Verificar se há configurações de senhas
$sql = "SELECT * FROM configuracoes";
$result = $conn->query($sql);

echo "<h2>Configurações de Senhas</h2>\n";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>Tipo: " . $row['tipo_senha'] . " - Inicial: " . $row['numero_inicial'] . " - Final: " . $row['numero_final'] . "</p>\n";
    }
} else {
    echo "<p style='color: red;'>Nenhuma configuração de senha encontrada. É necessário configurar as faixas de senhas no painel de administração.</p>\n";
}

// Verificar se há guichês
$sql = "SELECT * FROM guiches";
$result = $conn->query($sql);

echo "<h2>Guichês</h2>\n";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>ID: " . $row['id'] . " - Nome: " . $row['nome'] . " - Status: " . ($row['status'] == 1 ? "Ativo" : "Inativo") . "</p>\n";
    }
} else {
    echo "<p style='color: red;'>Nenhum guichê encontrado. É necessário cadastrar guichês no painel de administração.</p>\n";
}

$conn->close();

echo "<br><a href='admin/'>Acessar Painel de Administração</a><br>\n";
echo "<a href='adicionar_dados_exemplo.php'>Adicionar Dados de Exemplo</a><br>\n";
?>