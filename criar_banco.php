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
    echo "Banco de dados 'senhas_atendimento' criado com sucesso ou já existente.<br>\n";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error . "<br>\n";
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
    echo "Tabela 'guiches' criada com sucesso ou já existente.<br>\n";
} else {
    echo "Erro ao criar tabela 'guiches': " . $conn->error . "<br>\n";
}

// Criar tabela de configurações
$sql = "CREATE TABLE IF NOT EXISTS configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_senha ENUM('normal', 'preferencial') NOT NULL,
    numero_inicial INT NOT NULL,
    numero_final INT NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'configuracoes' criada com sucesso ou já existente.<br>\n";
} else {
    echo "Erro ao criar tabela 'configuracoes': " . $conn->error . "<br>\n";
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
    echo "Tabela 'senhas_chamadas' criada com sucesso ou já existente.<br>\n";
} else {
    echo "Erro ao criar tabela 'senhas_chamadas': " . $conn->error . "<br>\n";
}

$conn->close();

echo "<br>Processo de criação do banco de dados concluído!<br>\n";
echo "<a href='adicionar_dados_exemplo.php'>Clique aqui para adicionar dados de exemplo</a><br>\n";
echo "<a href='admin/'>Clique aqui para acessar o painel de administração</a><br>\n";
?>