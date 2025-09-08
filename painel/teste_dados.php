<?php
// Script para testar a conexão com o banco de dados e verificar se há dados
include '../includes/conexao_db.php';
include '../includes/funcoes.php';

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

echo "Conexão com o banco de dados bem-sucedida!<br>
";

// Verificar se há dados nas tabelas
$tabelas = ['guiches', 'configuracoes', 'senhas_chamadas'];

foreach ($tabelas as $tabela) {
    $sql = "SELECT COUNT(*) as total FROM $tabela";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    echo "Tabela '$tabela': " . $row['total'] . " registros<br>
";
}

// Testar a função obterUltimasSenhasChamadas
echo "<h2>Testando função obterUltimasSenhasChamadas</h2>
";
$historico = obterUltimasSenhasChamadas($conn, 5);
echo "<pre>
";
print_r($historico);
echo "</pre>
";

// Consulta direta para verificar senhas chamadas
echo "<h2>Consulta direta de senhas chamadas</h2>
";
$sql = "SELECT sc.tipo_senha, sc.numero_senha, g.nome as guiche_nome 
        FROM senhas_chamadas sc 
        JOIN guiches g ON sc.guiche_id = g.id 
        ORDER BY sc.data_hora DESC 
        LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<pre>
";
    while($row = $result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>
";
} else {
    echo "Nenhuma senha chamada encontrada.<br>
";
}

$conn->close();
?>