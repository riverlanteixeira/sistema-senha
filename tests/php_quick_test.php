<?php
// Teste rápido para verificar o PHP CLI e validações básicas
echo "PHP CLI quick test\n";
echo "php_version: " . phpversion() . PHP_EOL;
echo "SAPI: " . php_sapi_name() . PHP_EOL;
// checagens simples
echo "json_encode available: " . (function_exists('json_encode') ? 'yes' : 'no') . PHP_EOL;
echo "mbstring available: " . (function_exists('mb_strlen') ? 'yes' : 'no') . PHP_EOL;
// pequeno output para confirmar execução prevista
echo "TEST OK\n";

?>
