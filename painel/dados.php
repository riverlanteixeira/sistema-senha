<?php
// Endpoint para fornecer dados em tempo real para o painel público
include '../includes/conexao_db.php';
include '../includes/funcoes.php';

// Verificar a conexão
if ($conn->connect_error) {
    die(json_encode(['error' => 'Falha na conexão com o banco de dados']));
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
$historico_senhas = obterUltimasSenhasChamadas($conn, 5);

// Retornar os dados em formato JSON
header('Content-Type: application/json');
echo json_encode([
    'senha_atual' => $senha_atual,
    'historico_senhas' => $historico_senhas
]);

$conn->close();
?>