<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Público - Sistema de Senhas</title>
    <link href="../assets/css/estilo.css" rel="stylesheet">
</head>
<body>
    <div class="painel-header">
        POLÍCIA CIVIL DE SANTA CATARINA
    </div>
    
    <div class="painel-main-content">
        <div class="senha-atual">
            <h2>SENHA ATUAL</h2>
            <h3 id="senha_atual">Nenhuma senha chamada</h3>
            <h3 id="guiche_atual">Guichê: --</h3>
        </div>
        
        <div class="ultimas-senhas">
            <h3>ÚLTIMAS SENHAS CHAMADAS</h3>
            <div id="historico_senhas" class="senhas-container">
                <!-- Histórico será preenchido via AJAX -->
            </div>
        </div>
    </div>
    
    <div class="atualizacao">
        <p>Última atualização: <span id="data_hora">--/--/---- --:--:--</span></p>
    </div>

    <script>
        // Função para atualizar o painel
        function atualizarPainel() {
            // Fazer uma chamada AJAX para obter os dados do servidor
            fetch('dados.php')
                .then(response => response.json())
                .then(data => {
                    // Atualizar a senha atual
                    if (data.senha_atual) {
                        const tipo = data.senha_atual.tipo_senha.charAt(0).toUpperCase();
                        document.getElementById('senha_atual').textContent = tipo + ' ' + data.senha_atual.numero_senha;
                        document.getElementById('guiche_atual').textContent = 'Guichê: ' + data.senha_atual.guiche_nome;
                    } else {
                        document.getElementById('senha_atual').textContent = 'Nenhuma senha chamada';
                        document.getElementById('guiche_atual').textContent = 'Guichê: --';
                    }
                    
                    // Atualizar o histórico de senhas
                    const historicoContainer = document.getElementById('historico_senhas');
                    historicoContainer.innerHTML = '';
                    
                    if (data.historico_senhas.length > 0) {
                        data.historico_senhas.forEach(senha => {
                            const tipo = senha.tipo_senha.charAt(0).toUpperCase();
                            const senhaDiv = document.createElement('div');
                            senhaDiv.className = 'senha-historico';
                            senhaDiv.textContent = tipo + ' ' + senha.numero_senha;
                            historicoContainer.appendChild(senhaDiv);
                        });
                    } else {
                        const senhaDiv = document.createElement('div');
                        senhaDiv.className = 'senha-historico';
                        senhaDiv.textContent = 'Nenhuma senha chamada';
                        historicoContainer.appendChild(senhaDiv);
                    }
                    
                    // Atualizar data e hora
                    const agora = new Date();
                    const dataHora = agora.toLocaleDateString('pt-BR') + ' ' + agora.toLocaleTimeString('pt-BR');
                    document.getElementById('data_hora').textContent = dataHora;
                })
                .catch(error => {
                    console.error('Erro ao atualizar o painel:', error);
                })
                .finally(() => {
                    // Agendar a próxima atualização em 3 segundos
                    setTimeout(atualizarPainel, 3000);
                });
        }
        
        // Iniciar atualização do painel
        atualizarPainel();
    </script>
</body>
</html>