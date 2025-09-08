<?php
// Script para testar o funcionamento completo do sistema
echo "<h1>Teste Completo do Sistema de Senhas</h1>\n";

// Testar conexão com o banco de dados
echo "<h2>1. Testando conexão com o banco de dados</h2>\n";
include 'includes/conexao_db.php';

if ($conn->connect_error) {
    echo "<p style='color: red;'>Falha na conexão: " . $conn->connect_error . "</p>\n";
} else {
    echo "<p style='color: green;'>Conexão com o banco de dados bem-sucedida!</p>\n";
}

// Testar se as tabelas existem
echo "<h2>2. Verificando tabelas do banco de dados</h2>\n";
$tabelas = ['guiches', 'configuracoes', 'senhas_chamadas'];
$todas_existem = true;

foreach ($tabelas as $tabela) {
    $sql = "SHOW TABLES LIKE '$tabela'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>Tabela '$tabela' existe</p>\n";
    } else {
        echo "<p style='color: red;'>Tabela '$tabela' não existe</p>\n";
        $todas_existem = false;
    }
}

if (!$todas_existem) {
    echo "<p style='color: red;'>Algumas tabelas estão faltando. Execute o script criar_banco.php.</p>\n";
    $conn->close();
    exit;
}

// Testar dados de exemplo
echo "<h2>3. Verificando dados de exemplo</h2>\n";
$dados_ok = true;

// Verificar guichês
$sql = "SELECT COUNT(*) as total FROM guiches";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($row['total'] > 0) {
    echo "<p style='color: green;'>Guichês cadastrados: " . $row['total'] . "</p>\n";
} else {
    echo "<p style='color: orange;'>Nenhum guichê cadastrado. Execute adicionar_dados_exemplo.php</p>\n";
    $dados_ok = false;
}

// Verificar configurações
$sql = "SELECT COUNT(*) as total FROM configuracoes";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($row['total'] > 0) {
    echo "<p style='color: green;'>Configurações cadastradas: " . $row['total'] . "</p>\n";
} else {
    echo "<p style='color: orange;'>Nenhuma configuração cadastrada. Execute adicionar_dados_exemplo.php</p>\n";
    $dados_ok = false;
}

// Testar funções do sistema
if ($dados_ok) {
    echo "<h2>4. Testando funções do sistema</h2>\n";
    include 'includes/funcoes.php';
    
    // Testar obtenção de próxima senha
    $proxima_normal = obterProximaSenha($conn, 'normal');
    if ($proxima_normal !== null) {
        echo "<p style='color: green;'>Próxima senha normal disponível: $proxima_normal</p>\n";
    } else {
        echo "<p style='color: red;'>Não foi possível obter a próxima senha normal</p>\n";
    }
    
    $proxima_preferencial = obterProximaSenha($conn, 'preferencial');
    if ($proxima_preferencial !== null) {
        echo "<p style='color: green;'>Próxima senha preferencial disponível: $proxima_preferencial</p>\n";
    } else {
        echo "<p style='color: red;'>Não foi possível obter a próxima senha preferencial</p>\n";
    }
    
    // Testar registro de chamada de senha (apenas se houver senhas disponíveis)
    if ($proxima_normal !== null) {
        $resultado = registrarChamadaSenha($conn, 'normal', $proxima_normal, 1);
        if ($resultado) {
            echo "<p style='color: green;'>Registro de chamada de senha normal bem-sucedido</p>\n";
        } else {
            echo "<p style='color: red;'>Falha ao registrar chamada de senha normal</p>\n";
        }
    }
}

$conn->close();

echo "<h2>5. Teste concluído</h2>\n";
echo "<p>Se todos os testes passaram, o sistema está funcionando corretamente.</p>\n";
echo "<a href='admin/'>Acessar Painel de Administração</a><br>\n";
echo "<a href='operador/'>Acessar Módulo do Operador</a><br>\n";
echo "<a href='painel/'>Acessar Painel Público</a><br>\n";
?>