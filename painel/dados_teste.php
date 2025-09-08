<?php
// Endpoint para fornecer dados em tempo real para o painel público - Versão de teste com depuração
header('Content-Type: application/json');

include '../includes/conexao_db.php';
include '../includes/funcoes.php';

// Verificar a conexão
if ($conn->connect_error) {
    echo json_encode(['error' => 'Falha na conexão com o banco de dados: ' . $conn->connect_error]);
    exit;
}

// Verificar se as tabelas existem
$tabelas = ['guiches', 'senhas_chamadas'];
foreach ($tabelas as $tabela) {
    $sql = "SHOW TABLES LIKE '$tabela'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo json_encode(['error' => "Tabela '$tabela' não existe"]);
        exit;
    }
}

// Obter a última senha chamada
$sql = "SELECT sc.tipo_senha, sc.numero_senha, g.nome as guiche_nome 
        FROM senhas_chamadas sc 
        JOIN guiches g ON sc.guiche_id = g.id 
        ORDER BY sc.data_hora DESC 
        LIMIT 1";
$result = $conn->query($sql);

$senha_atual = null;
if ($result && $result->num_rows > 0) {
    $senha_atual = $result->fetch_assoc();
}

// Obter as últimas 5 senhas chamadas
$historico_senhas = [];
try {
    $historico_senhas = obterUltimasSenhasChamadas($conn, 5);
} catch (Exception $e) {
    echo json_encode(['error' => 'Erro ao obter histórico: ' . $e->getMessage()]);
    exit;
}

// Retornar os dados em formato JSON
$response = [
    'senha_atual' => $senha_atual,
    'historico_senhas' => $historico_senhas,
    'debug' => [
        'total_historico' => count($historico_senhas),
        'timestamp' => date('Y-m-d H:i:s')
    ]
];

echo json_encode($response);
$conn->close();
?>