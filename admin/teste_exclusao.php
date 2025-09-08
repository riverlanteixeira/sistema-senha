<?php
// Script para testar a funcionalidade de exclusão de guichês
include '../includes/conexao_db.php';

echo "<h1>Teste de Exclusão de Guichês</h1>
";

// Verificar guichês existentes
$sql = "SELECT g.*, COUNT(sc.id) as total_senhas FROM guiches g LEFT JOIN senhas_chamadas sc ON g.id = sc.guiche_id GROUP BY g.id ORDER BY g.id";
$result = $conn->query($sql);

echo "<h2>Guichês atuais:</h2>
";
if ($result->num_rows > 0) {
    echo "<table border='1'>
";
    echo "<tr><th>ID</th><th>Nome</th><th>Status</th><th>Senhas Associadas</th><th>Pode Excluir?</th></tr>
";
    while($row = $result->fetch_assoc()) {
        $pode_excluir = $row['total_senhas'] == 0 ? "Sim" : "Não";
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . ($row['status'] == 1 ? "Ativo" : "Inativo") . "</td>";
        echo "<td>" . $row['total_senhas'] . "</td>";
        echo "<td>" . $pode_excluir . "</td>";
        echo "</tr>
";
    }
    echo "</table>
";
} else {
    echo "<p>Nenhum guichê encontrado.</p>
";
}

$conn->close();

echo "<h2>Instruções para teste:</h2>
";
echo "<p>1. Acesse o <a href='index.php'>Painel de Administração</a> e tente excluir um guichê.</p>
";
echo "<p>2. Guichês com senhas associadas não podem ser excluídos (medida de segurança).</p>
";
echo "<p>3. Guichês sem senhas associadas podem ser excluídos normalmente.</p>
";
echo "<p>4. Você verá mensagens de feedback indicando o sucesso ou falha da operação.</p>
";
?>