<?php
// Script para testar o envio de dados do formulário de configuração de senhas
echo "<h1>Teste de Envio de Dados do Formulário</h1>\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Dados recebidos via POST:</h2>\n";
    echo "<pre>\n";
    print_r($_POST);
    echo "</pre>\n";
    
    $tipo = $_POST['tipo'] ?? '';
    $inicial = $_POST['inicial_' . $tipo] ?? 0;
    $final = $_POST['final_' . $tipo] ?? 0;
    
    echo "<h2>Variáveis extraídas:</h2>\n";
    echo "<p>Tipo: " . $tipo . "</p>\n";
    echo "<p>Inicial: " . $inicial . "</p>\n";
    echo "<p>Final: " . $final . "</p>\n";
    
    if (!empty($tipo) && $inicial > 0 && $final > 0) {
        echo "<p style='color: green;'>Todos os dados estão corretos e prontos para salvar!</p>\n";
    } else {
        echo "<p style='color: red;'>Há dados faltando ou inválidos:</p>\n";
        if (empty($tipo)) echo "<p>- Tipo está vazio</p>\n";
        if ($inicial <= 0) echo "<p>- Valor inicial inválido: " . $inicial . "</p>\n";
        if ($final <= 0) echo "<p>- Valor final inválido: " . $final . "</p>\n";
    }
} else {
    echo "<p>Nenhum dado POST recebido.</p>\n";
    echo "<p>Este script deve ser chamado via POST para testar o envio de dados.</p>\n";
}
?>
