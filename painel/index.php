<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Público - Sistema de Senhas</title>
    <link href="../assets/css/shadcn.css" rel="stylesheet">
    <style>
        :root {
            --background: 0 0% 0%;
            --foreground: 0 0% 100%;
            --primary: 0 72% 51%;
            --primary-foreground: 45 100% 51%;
            --secondary: 0 0% 20%;
            --secondary-foreground: 0 0% 90%;
            --muted: 0 0% 15%;
            --muted-foreground: 0 0% 60%;
            --border: 45 100% 51%;
            --ring: 45 100% 51%;
            --radius: 0.5rem;
        }
        
        body {
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }
        
        .header {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
            text-align: center;
            padding: 1rem 0;
            font-size: 2.5rem;
            font-weight: bold;
            border-bottom: 5px solid hsl(var(--primary-foreground));
        }
        
        .main-content {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 120px);
            padding: 1rem;
        }
        
        .senha-atual {
            background-color: hsl(var(--foreground));
            color: hsl(var(--background));
            border: 5px solid hsl(var(--primary-foreground));
            border-radius: var(--radius);
            padding: 2rem;
            margin-bottom: 1rem;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .senha-atual h2 {
            font-size: 3rem;
            margin: 0 0 1rem 0;
            color: hsl(var(--primary));
        }
        
        .senha-atual h3 {
            font-size: 6rem;
            margin: 0;
            font-weight: bold;
        }
        
        .ultimas-senhas {
            background-color: hsl(var(--secondary));
            border-radius: var(--radius);
            padding: 1.5rem;
            flex: 1;
        }
        
        .ultimas-senhas h3 {
            color: hsl(var(--primary-foreground));
            text-align: center;
            margin: 0 0 1rem 0;
            font-size: 2rem;
        }
        
        .senhas-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            height: calc(100% - 4rem);
        }
        
        .senha-historico {
            background-color: hsl(var(--muted));
            border-radius: calc(var(--radius) - 2px);
            padding: 1rem;
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .atualizacao {
            text-align: center;
            color: hsl(var(--muted-foreground));
            font-style: italic;
            padding: 0.5rem;
            font-size: 1rem;
        }
        
        .card {
            background: hsl(var(--secondary));
            border-radius: var(--radius);
            border: 1px solid hsl(var(--border));
        }
        
        .card-header {
            padding: 1rem;
            border-bottom: 1px solid hsl(var(--border));
        }
        
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            color: hsl(var(--primary-foreground));
        }
        
        .card-content {
            padding: 1rem;
        }
    </style>
</head>
<body>
    <div class="header">
        SISTEMA DE SENHAS DE ATENDIMENTO
    </div>
    
    <div class="main-content">
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