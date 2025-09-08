<?php
// Script de teste para verificar a funcionalidade de chamada de senhas
include 'includes/conexao_db.php';
include 'includes/funcoes.php';

echo "<h1>Teste de Funcionalidade de Chamada de Senhas</h1>\n";

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
}

if ($proxima_preferencial !== null) {
    $resultado = registrarChamadaSenha($conn, 'preferencial', $proxima_preferencial, 1);
    echo "<p>Registro de chamada de senha preferencial: " . ($resultado ? "Sucesso" : "Falha") . "</p>\n";
}

// Testar a função obterUltimasSenhasChamadas
echo "<h2>Testando função obterUltimasSenhasChamadas</h2>\n";
$historico = obterUltimasSenhasChamadas($conn, 5);
echo "<pre>\n";
print_r($historico);
echo "</pre>\n";

$conn->close();
?>