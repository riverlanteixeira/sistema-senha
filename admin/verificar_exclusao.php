<?php
// Script para verificar guichês que podem ser excluídos
include '../includes/conexao_db.php';

// Verificar guichês existentes
$sql = "SELECT g.*, COUNT(sc.id) as total_senhas FROM guiches g LEFT JOIN senhas_chamadas sc ON g.id = sc.guiche_id GROUP BY g.id ORDER BY g.id";
$result = $conn->query($sql);

echo "<h1>Guichês que podem ser excluídos</h1>\n";
if ($result->num_rows > 0) {
    echo "<table border='1'>\n";
    echo "<tr><th>ID</th><th>Nome</th><th>Status</th><th>Senhas Associadas</th><th>Pode Excluir?</th><th>Link para Excluir</th></tr>\n";
    while($row = $result->fetch_assoc()) {
        $pode_excluir = $row['total_senhas'] == 0 ? "Sim" : "Não";
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . ($row['status'] == 1 ? "Ativo" : "Inativo") . "</td>";
        echo "<td>" . $row['total_senhas'] . "</td>";
        echo "<td>" . $pode_excluir . "</td>";
        if ($row['total_senhas'] == 0) {
            echo "<td><a href='acao_guiche.php?acao=excluir&id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este guichê?\")'>Excluir</a></td>";
        } else {
            echo "<td>Não é possível excluir</td>";
        }
        echo "</tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p>Nenhum guichê encontrado.</p>\n";
}

$conn->close();
?>