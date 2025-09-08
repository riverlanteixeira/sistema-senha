<?php
// Script para verificar as configurações atuais de senhas
include '../includes/conexao_db.php';

echo "<h1>Verificação das Configurações de Senhas</h1>\n";

// Verificar configurações existentes
$sql = "SELECT * FROM configuracoes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Configurações atuais:</h2>\n";
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
    echo "<p>Nenhuma configuração de senhas encontrada.</p>\n";
}

$conn->close();

echo "<h2>Testar inserção manual:</h2>\n";
echo "<p><a href='inserir_config_teste.php'>Inserir configuração de teste</a></p>\n";
?>