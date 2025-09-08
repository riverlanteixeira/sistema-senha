# Documentação Técnica - Sistema de Gerenciamento de Senhas

## Estrutura de Diretórios

```
senha/
├── admin/
│   ├── index.php          # Painel de administração
│   ├── acao_guiche.php    # Ações relacionadas a guichês
│   └── acao_senhas.php    # Ações relacionadas a configurações de senhas
├── operador/
│   ├── index.php          # Interface do operador
│   └── chamar_senha.php   # Lógica para chamar senhas
├── painel/
│   ├── index.php          # Painel público
│   └── dados.php          # Endpoint para dados do painel
├── includes/
│   ├── conexao_db.php     # Configuração de conexão com o banco de dados
│   └── funcoes.php        # Funções auxiliares do sistema
├── docs/                  # Documentação do sistema
├── criar_banco.php        # Script para criação do banco de dados
├── adicionar_dados_exemplo.php  # Script para adicionar dados de exemplo
└── index.php              # Página inicial (redireciona para o painel)
```

## Banco de Dados

### Tabelas

#### 1. guiches
```sql
CREATE TABLE guiches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    status TINYINT(1) DEFAULT 1
);
```

#### 2. configuracoes
```sql
CREATE TABLE configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_senha ENUM('normal', 'preferencial') NOT NULL,
    numero_inicial INT NOT NULL,
    numero_final INT NOT NULL
);
```

#### 3. senhas_chamadas
```sql
CREATE TABLE senhas_chamadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_senha ENUM('normal', 'preferencial') NOT NULL,
    numero_senha INT NOT NULL,
    guiche_id INT NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (guiche_id) REFERENCES guiches(id)
);
```

## Componentes Principais

### Conexão com Banco de Dados
Arquivo: `includes/conexao_db.php`
- Configuração de conexão com MySQL
- Utiliza MySQLi para conexão orientada a objetos
- Tratamento de erros de conexão

### Funções Auxiliares
Arquivo: `includes/funcoes.php`

#### obterProximaSenha($conn, $tipo)
- Retorna a próxima senha disponível do tipo especificado
- Verifica as configurações de faixa para o tipo de senha
- Retorna null se não houver senhas disponíveis

#### registrarChamadaSenha($conn, $tipo, $numero, $guiche_id)
- Registra uma chamada de senha no banco de dados
- Retorna true em caso de sucesso, false em caso de falha

#### obterUltimasSenhasChamadas($conn, $limite = 5)
- Retorna as últimas senhas chamadas, ordenadas por data/hora
- Limite padrão de 5 registros

### Painel de Administração
Arquivo: `admin/index.php`
- Interface para gerenciamento de guichês e configurações
- Utiliza Bootstrap 5 para layout responsivo
- Abas para separar funcionalidades

### Módulo do Operador
Arquivo: `operador/index.php`
- Interface para chamada de senhas
- Exibição da última senha chamada
- Histórico de senhas chamadas pelo guichê

### Painel Público
Arquivo: `painel/index.php`
- Interface de exibição para clientes
- Design otimizado para visualização a distância
- Atualização automática via AJAX

### Endpoint de Dados do Painel
Arquivo: `painel/dados.php`
- Retorna dados em formato JSON para o painel público
- Fornece senha atual e histórico de senhas chamadas
- Utilizado pela função de atualização automática

## Fluxos de Processo

### Cadastro de Guichê
1. Usuário preenche nome do guichê no formulário
2. Dados enviados via POST para `admin/acao_guiche.php`
3. Script insere novo guichê no banco de dados
4. Redireciona de volta para `admin/index.php`

### Chamada de Senha
1. Operador clica em "Chamar Próxima Normal" ou "Chamar Próxima Preferencial"
2. Requisição enviada para `operador/chamar_senha.php` com parâmetro de tipo
3. Script obtém próxima senha disponível usando `obterProximaSenha()`
4. Registra chamada usando `registrarChamadaSenha()`
5. Redireciona de volta para `operador/index.php`

### Atualização do Painel Público
1. Página `painel/index.php` carrega e inicia função de atualização
2. A cada 3 segundos, função JavaScript faz requisição AJAX para `painel/dados.php`
3. Script PHP consulta banco de dados e retorna JSON com dados atualizados
4. JavaScript atualiza elementos da página com novos dados

## Segurança

### Considerações de Segurança
- O sistema é projetado para uso em ambiente local (intranet)
- Não implementa autenticação de usuários (por design)
- Todos os dados são validados antes de interagir com o banco de dados
- Utiliza prepared statements para prevenir SQL injection

### Melhorias Futuras
- Implementação de login para administradores
- Logs de auditoria para todas as operações
- Backup automático do banco de dados
- Interface para reset do sistema

## Requisitos do Sistema

### Servidor
- Windows com WAMP (ou LAMP em Linux)
- Apache 2.4+
- PHP 7.4+
- MySQL 5.7+

### Cliente
- Navegador web moderno (Chrome, Firefox, Edge)
- JavaScript habilitado
- Resolução mínima de 1024x768

### Rede
- Conexão de rede local (intranet)
- Latência baixa entre cliente e servidor
- Largura de banda adequada para atualizações AJAX