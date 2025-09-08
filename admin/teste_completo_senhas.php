<?php
// Script para testar completamente o processo de salvamento de configurações de senhas
include '../includes/conexao_db.php';

echo "<h1>Teste Completo do Processo de Configuração de Senhas</h1>\n";

// Verificar se há dados POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Dados recebidos via POST:</h2>\n";
    echo "<pre>\n";
    print_r($_POST);
    echo "</pre>\n";
    
    // Extrair dados
    $tipo = $_POST['tipo'] ?? '';
    $inicial = $_POST['inicial_' . $tipo] ?? 0;
    $final = $_POST['final_' . $tipo] ?? 0;
    
    echo "<h2>Dados extraídos:</h2>\n";
    echo "<p>Tipo: '$tipo'</p>\n";
    echo "<p>Inicial: '$inicial' (tipo: " . gettype($inicial) . ")</p>\n";
    echo "<p>Final: '$final' (tipo: " . gettype($final) . ")</p>\n";
    
    // Validar dados
    if (!empty($tipo) && $inicial > 0 && $final > 0) {
        echo "<p style='color: green;'>Dados válidos. Prosseguindo com o salvamento...</p>\n";
        
        // Verificar se já existe configuração para este tipo de senha
        $sql = "SELECT id FROM configuracoes WHERE tipo_senha = ?";
        echo "<p>Consulta SQL: $sql</p>\n";
        
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            echo "<p style='color: green;'>Prepared statement criado com sucesso.</p>\n";
            $stmt->bind_param("s", $tipo);
            echo "<p>Parâmetros vinculados.</p>\n";
            
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Consulta executada com sucesso.</p>\n";
                $result = $stmt->get_result();
                echo "<p>Número de registros encontrados: " . $result->num_rows . "</p>\n";
                
                if ($result->num_rows > 0) {
                    // Atualiza a configuração existente
                    $row = $result->fetch_assoc();
                    $sql = "UPDATE configuracoes SET numero_inicial = ?, numero_final = ? WHERE id = ?";
                    echo "<p>SQL de atualização: $sql</p>\n";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("iii", $inicial, $final, $row['id']);
                        if ($stmt->execute()) {
                            echo "<p style='color: green;'>Configuração atualizada com sucesso!</p>\n";
                        } else {
                            echo "<p style='color: red;'>Erro ao atualizar configuração: " . $stmt->error . "</p>\n";
                        }
                    } else {
                        echo "<p style='color: red;'>Erro ao preparar statement de atualização: " . $conn->error . "</p>\n";
                    }
                } else {
                    // Insere nova configuração
                    $sql = "INSERT INTO configuracoes (tipo_senha, numero_inicial, numero_final) VALUES (?, ?, ?)";
                    echo "<p>SQL de inserção: $sql</p>\n";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("sii", $tipo, $inicial, $final);
                        if ($stmt->execute()) {
                            echo "<p style='color: green;'>Nova configuração inserida com sucesso!</p>\n";
                        } else {
                            echo "<p style='color: red;'>Erro ao inserir configuração: " . $stmt->error . "</p>\n";
                        }
                    } else {
                        echo "<p style='color: red;'>Erro ao preparar statement de inserção: " . $conn->error . "</p>\n";
                    }
                }
                $stmt->close();
            } else {
                echo "<p style='color: red;'>Erro ao executar consulta: " . $stmt->error . "</p>\n";
            }
        } else {
            echo "<p style='color: red;'>Erro ao preparar statement: " . $conn->error . "</p>\n";
        }
    } else {
        echo "<p style='color: red;'>Dados inválidos:</p>\n";
        if (empty($tipo)) echo "<p>- Tipo está vazio</p>\n";
        if ($inicial <= 0) echo "<p>- Valor inicial inválido: '$inicial'</p>\n";
        if ($final <= 0) echo "<p>- Valor final inválido: '$final'</p>\n";
    }
} else {
    echo "<p>Nenhum dado POST recebido.</p>\n";
}

// Mostrar configurações atuais
echo "<h2>Configurações atuais no banco de dados:</h2>\n";
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
    echo "<p>Nenhuma configuração encontrada.</p>\n";
}

$conn->close();

echo "<h2>Formulário de teste:</h2>\n";
echo "<form method='POST'>\n";
echo "<input type='hidden' name='tipo' value='normal'>\n";
echo "<p><input type='number' name='inicial_normal' value='1' placeholder='Inicial'> Valor inicial</p>\n";
echo "<p><input type='number' name='final_normal' value='100' placeholder='Final'> Valor final</p>\n";
echo "<button type='submit'>Testar Salvamento</button>\n";
echo "</form>\n";
?>