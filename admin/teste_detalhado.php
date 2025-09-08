<?php
// Script para testar exatamente o que está acontecendo com o envio dos dados
echo "<h1>Teste Detalhado do Envio de Dados</h1>\n";

echo "<h2>Método da requisição:</h2>\n";
echo "<p>" . $_SERVER['REQUEST_METHOD'] . "</p>\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Dados recebidos via POST:</h2>\n";
    echo "<pre>\n";
    print_r($_POST);
    echo "</pre>\n";
    
    // Verificar cada campo individualmente
    echo "<h2>Verificação individual dos campos:</h2>\n";
    
    if (isset($_POST['tipo'])) {
        $tipo = $_POST['tipo'];
        echo "<p>Tipo: " . $tipo . "</p>\n";
        
        // Verificar campos específicos para o tipo
        $campo_inicial = 'inicial_' . $tipo;
        $campo_final = 'final_' . $tipo;
        
        echo "<p>Nome do campo inicial esperado: " . $campo_inicial . "</p>\n";
        echo "<p>Nome do campo final esperado: " . $campo_final . "</p>\n";
        
        if (isset($_POST[$campo_inicial])) {
            echo "<p style='color: green;'>Campo inicial encontrado: " . $_POST[$campo_inicial] . "</p>\n";
        } else {
            echo "<p style='color: red;'>Campo inicial NÃO encontrado</p>\n";
            // Verificar todos os campos disponíveis
            echo "<p>Campos disponíveis:</p>\n";
            foreach ($_POST as $key => $value) {
                echo "<p>- " . $key . " = " . $value . "</p>\n";
            }
        }
        
        if (isset($_POST[$campo_final])) {
            echo "<p style='color: green;'>Campo final encontrado: " . $_POST[$campo_final] . "</p>\n";
        } else {
            echo "<p style='color: red;'>Campo final NÃO encontrado</p>\n";
        }
    } else {
        echo "<p style='color: red;'>Campo 'tipo' NÃO encontrado</p>\n";
    }
} else {
    echo "<p>Nenhum dado POST recebido.</p>\n";
    echo "<p>Formulário para teste:</p>\n";
    echo "<form method='POST'>\n";
    echo "<input type='hidden' name='tipo' value='normal'>\n";
    echo "<input type='number' name='inicial_normal' value='1'>\n";
    echo "<input type='number' name='final_normal' value='100'>\n";
    echo "<button type='submit'>Enviar</button>\n";
    echo "</form>\n";
}
?>