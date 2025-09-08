<?php
// Script para verificar os dados diretamente no banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'senhas_atendimento';

// Conectar ao MySQL
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

echo "<h1>Verificação Direta dos Dados no Banco de Dados</h1>\n";

// Verificar guichês
echo "<h2>Guichês</h2>\n";
$sql = "SELECT * FROM guiches";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>\n";
    echo "<tr><th>ID</th><th>Nome</th><th>Status</th></tr>\n";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . ($row['status'] == 1 ? "Ativo" : "Inativo") . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p>Nenhum guichê encontrado.</p>\n";
}

// Verificar configurações de senhas
echo "<h2>Configurações de Senhas</h2>\n";
$sql = "SELECT * FROM configuracoes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>\n";
    echo "<tr><th>ID</th><th>Tipo</th><th>Inicial</th><th>Final</th></tr>\n";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['tipo_senha'] . "</td>";
        echo "<td>" . $row['numero_inicial'] . "</td>";
        echo "<td>" . $row['numero_final'] . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p>Nenhuma configuração de senha encontrada.</p>\n";
}

// Verificar senhas chamadas
echo "<h2>Senhas Chamadas</h2>\n";
$sql = "SELECT sc.*, g.nome as guiche_nome FROM senhas_chamadas sc JOIN guiches g ON sc.guiche_id = g.id ORDER BY sc.data_hora DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>\n";
    echo "<tr><th>ID</th><th>Tipo</th><th>Número</th><th>Guichê</th><th>Data/Hora</th></tr>\n";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['tipo_senha'] . "</td>";
        echo "<td>" . $row['numero_senha'] . "</td>";
        echo "<td>" . $row['guiche_nome'] . "</td>";
        echo "<td>" . $row['data_hora'] . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p>Nenhuma senha chamada encontrada.</p>\n";
}

$conn->close();
?>