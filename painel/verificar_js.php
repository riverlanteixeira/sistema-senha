<?php
// Script para verificar se há erros no JavaScript do painel
$html = file_get_contents('index.php');

// Verificar se o arquivo foi carregado corretamente
if ($html === false) {
    echo "Erro ao carregar o arquivo index.php";
    exit;
}

echo "<h1>Análise do Código JavaScript do Painel</h1>\n";

// Extrair o código JavaScript
$pattern = '/<script[^>]*>(.*?)<\/script>/s';
preg_match_all($pattern, $html, $matches);

if (count($matches[1]) > 0) {
    echo "<h2>Código JavaScript encontrado:</h2>\n";
    foreach ($matches[1] as $jsCode) {
        echo "<pre>" . htmlspecialchars($jsCode) . "</pre>\n";
        
        // Verificar se há erros óbvios no código
        if (strpos($jsCode, 'fetch') !== false) {
            echo "<p>O código utiliza fetch para fazer requisições AJAX.</p>\n";
        }
        
        if (strpos($jsCode, 'atualizarPainel') !== false) {
            echo "<p>A função atualizarPainel está definida.</p>\n";
        }
        
        if (strpos($jsCode, 'dados.php') !== false) {
            echo "<p>O código faz requisições para dados.php.</p>\n";
        }
    }
} else {
    echo "<p>Nenhum código JavaScript encontrado.</p>\n";
}

echo "<h2>Verificação de recursos externos:</h2>\n";
if (strpos($html, 'bootstrap') !== false) {
    echo "<p>Bootstrap está sendo carregado.</p>\n";
}

if (strpos($html, 'dados.php') !== false) {
    echo "<p>O endpoint dados.php está sendo referenciado.</p>\n";
}
?>