<?php
// Script para verificar se há algum erro no endpoint de dados do painel
include '../includes/conexao_db.php';
include '../includes/funcoes.php';

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se há dados nas tabelas
echo "Verificando dados nas tabelas...<br>\n";

$tabelas = ['guiches', 'configuracoes', 'senhas_chamadas'];
foreach ($tabelas as $tabela) {
    $sql = "SELECT COUNT(*) as total FROM $tabela";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    echo "Tabela '$tabela': " . $row['total'] . " registros<br>\n";
}

// Testar a consulta do painel
echo "<h2>Testando consulta do painel</h2>\n";

// Obter a última senha chamada
$sql = "SELECT sc.tipo_senha, sc.numero_senha, g.nome as guiche_nome 
        FROM senhas_chamadas sc 
        JOIN guiches g ON sc.guiche_id = g.id 
        ORDER BY sc.data_hora DESC 
        LIMIT 1";
$result = $conn->query($sql);

$senha_atual = null;
if ($result->num_rows > 0) {
    $senha_atual = $result->fetch_assoc();
    echo "Senha atual encontrada:<br>\n";
    print_r($senha_atual);
} else {
    echo "Nenhuma senha atual encontrada.<br>\n";
}

// Obter as últimas 5 senhas chamadas
echo "<h2>Testando obtenção do histórico</h2>\n";
$historico_senhas = obterUltimasSenhasChamadas($conn, 5);

if (count($historico_senhas) > 0) {
    echo "Histórico encontrado:<br>\n";
    print_r($historico_senhas);
} else {
    echo "Nenhum histórico encontrado.<br>\n";
}

// Retornar os dados em formato JSON (como no endpoint original)
header('Content-Type: application/json');
echo json_encode([
    'senha_atual' => $senha_atual,
    'historico_senhas' => $historico_senhas
]);

$conn->close();
?>