<?php
// Script para criar o banco de dados e tabelas necessárias
$host = 'localhost';
$usuario = 'root';
$senha = '';

// Conectar ao MySQL
$conn = new mysqli($host, $usuario, $senha);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criar o banco de dados
$sql = "CREATE DATABASE IF NOT EXISTS senhas_atendimento CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados 'senhas_atendimento' criado com sucesso ou já existente.<br>
";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error . "<br>
";
}

// Selecionar o banco de dados
$conn->select_db('senhas_atendimento');

// Criar tabela de guichês
$sql = "CREATE TABLE IF NOT EXISTS guiches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    status TINYINT(1) DEFAULT 1
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'guiches' criada com sucesso ou já existente.<br>
";
} else {
    echo "Erro ao criar tabela 'guiches': " . $conn->error . "<br>
";
}

// Criar tabela de configurações
$sql = "CREATE TABLE IF NOT EXISTS configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_senha ENUM('normal', 'preferencial') NOT NULL,
    numero_inicial INT NOT NULL,
    numero_final INT NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'configuracoes' criada com sucesso ou já existente.<br>
";
} else {
    echo "Erro ao criar tabela 'configuracoes': " . $conn->error . "<br>
";
}

// Criar tabela de senhas chamadas
$sql = "CREATE TABLE IF NOT EXISTS senhas_chamadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_senha ENUM('normal', 'preferencial') NOT NULL,
    numero_senha INT NOT NULL,
    guiche_id INT NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (guiche_id) REFERENCES guiches(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'senhas_chamadas' criada com sucesso ou já existente.<br>
";
} else {
    echo "Erro ao criar tabela 'senhas_chamadas': " . $conn->error . "<br>
";
}

// Criar tabela de usuários
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel ENUM('admin', 'operador') NOT NULL,
    ativo TINYINT(1) DEFAULT 1,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'usuarios' criada com sucesso ou já existente.<br>
";
} else {
    echo "Erro ao criar tabela 'usuarios': " . $conn->error . "<br>
";
}

$conn->close();

echo "<br>Processo de criação do banco de dados concluído!<br>
";
echo "<a href='adicionar_dados_exemplo.php'>Clique aqui para adicionar dados de exemplo</a><br>
";
echo "<a href='admin/'>Clique aqui para acessar o painel de administração</a><br>
";
?>