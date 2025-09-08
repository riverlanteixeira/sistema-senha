<?php
// Conexão com o banco de dados MySQL
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'senhas_atendimento';

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>