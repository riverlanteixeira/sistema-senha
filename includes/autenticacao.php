<?php
// Script para verificar autenticação do usuário
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Função para verificar se o usuário está logado
function verificarAutenticacao() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

// Função para verificar se o usuário é administrador
function verificarAdministrador() {
    verificarAutenticacao();
    // Neste sistema simplificado, qualquer usuário autenticado pode acessar
}

// Função para verificar se o usuário é operador
function verificarOperador() {
    verificarAutenticacao();
    // Neste sistema simplificado, qualquer usuário autenticado pode acessar
}

// Função para obter o nome do usuário logado
function obterNomeUsuario() {
    return $_SESSION['usuario_nome'] ?? 'Usuário';
}
?>