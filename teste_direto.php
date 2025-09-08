<?php
// Script para testar diretamente a chamada de senhas
include 'includes/conexao_db.php';
include 'includes/funcoes.php';

echo "<h1>Teste Direto de Chamada de Senhas</h1>\n";

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

// Testar obtenção de próxima senha normal
echo "<h2>Obtenção de Próxima Senha Normal</h2>\n";
$proxima_normal = obterProximaSenha($conn, 'normal');
echo "<p>Próxima senha normal: " . ($proxima_normal !== null ? $proxima_normal : "Nenhuma disponível") . "</p>\n";

// Testar obtenção de próxima senha preferencial
echo "<h2>Obtenção de Próxima Senha Preferencial</h2>\n";
$proxima_preferencial = obterProximaSenha($conn, 'preferencial');
echo "<p>Próxima senha preferencial: " . ($proxima_preferencial !== null ? $proxima_preferencial : "Nenhuma disponível") . "</p>\n";

// Testar registro de chamada de senha normal
echo "<h2>Registro de Chamada de Senha Normal</h2>\n";
if ($proxima_normal !== null) {
    echo "<p>Tentando registrar senha normal: $proxima_normal</p>\n";
    $resultado = registrarChamadaSenha($conn, 'normal', $proxima_normal, 1);
    echo "<p>Resultado: " . ($resultado ? "Sucesso" : "Falha") . "</p>\n";
} else {
    echo "<p>Não foi possível registrar senha normal pois não há senha disponível.</p>\n";
}

// Testar registro de chamada de senha preferencial
echo "<h2>Registro de Chamada de Senha Preferencial</h2>\n";
if ($proxima_preferencial !== null) {
    echo "<p>Tentando registrar senha preferencial: $proxima_preferencial</p>\n";
    $resultado = registrarChamadaSenha($conn, 'preferencial', $proxima_preferencial, 1);
    echo "<p>Resultado: " . ($resultado ? "Sucesso" : "Falha") . "</p>\n";
} else {
    echo "<p>Não foi possível registrar senha preferencial pois não há senha disponível.</p>\n";
}

$conn->close();
?>