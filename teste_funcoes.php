<?php
// Script para testar individualmente cada função
include '../includes/conexao_db.php';
include '../includes/funcoes.php';

echo "<h1>Teste Individual de Funções</h1>\n";

// Testar a função obterProximaSenha
echo "<h2>Testando função obterProximaSenha</h2>\n";
$proxima_normal = obterProximaSenha($conn, 'normal');
$proxima_preferencial = obterProximaSenha($conn, 'preferencial');

echo "<p>Próxima senha normal: " . ($proxima_normal !== null ? $proxima_normal : "Nenhuma disponível") . "</p>\n";
echo "<p>Próxima senha preferencial: " . ($proxima_preferencial !== null ? $proxima_preferencial : "Nenhuma disponível") . "</p>\n";

// Testar a função registrarChamadaSenha
echo "<h2>Testando função registrarChamadaSenha</h2>\n";
if ($proxima_normal !== null) {
    $resultado = registrarChamadaSenha($conn, 'normal', $proxima_normal, 1);
    echo "<p>Registro de chamada de senha normal: " . ($resultado ? "Sucesso" : "Falha") . "</p>\n";
} else {
    echo "<p>Não foi possível testar o registro de senha normal pois não há senha disponível.</p>\n";
}

if ($proxima_preferencial !== null) {
    $resultado = registrarChamadaSenha($conn, 'preferencial', $proxima_preferencial, 1);
    echo "<p>Registro de chamada de senha preferencial: " . ($resultado ? "Sucesso" : "Falha") . "</p>\n";
} else {
    echo "<p>Não foi possível testar o registro de senha preferencial pois não há senha disponível.</p>\n";
}

// Testar a função obterUltimasSenhasChamadas
echo "<h2>Testando função obterUltimasSenhasChamadas</h2>\n";
$historico = obterUltimasSenhasChamadas($conn, 5);

if (count($historico) > 0) {
    echo "<pre>\n";
    print_r($historico);
    echo "</pre>\n";
} else {
    echo "<p>Nenhum histórico de senhas encontrado.</p>\n";
}

// Verificar configurações
echo "<h2>Configurações de Senhas</h2>\n";
$sql = "SELECT * FROM configuracoes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>Tipo: " . $row['tipo_senha'] . " - Inicial: " . $row['numero_inicial'] . " - Final: " . $row['numero_final'] . "</p>\n";
    }
} else {
    echo "<p style='color: red;'>Nenhuma configuração de senha encontrada.</p>\n";
}

// Verificar guichês
echo "<h2>Guichês</h2>\n";
$sql = "SELECT * FROM guiches";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>ID: " . $row['id'] . " - Nome: " . $row['nome'] . " - Status: " . ($row['status'] == 1 ? "Ativo" : "Inativo") . "</p>\n";
    }
} else {
    echo "<p style='color: red;'>Nenhum guichê encontrado.</p>\n";
}

$conn->close();
?>