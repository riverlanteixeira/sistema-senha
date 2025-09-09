# QWEN.md - Contexto do Projeto Sistema de Gerenciamento de Senhas

## Visão Geral do Projeto

O Sistema de Gerenciamento de Senhas é uma aplicação web desenvolvida em PHP com MySQL para gerenciar filas de atendimento presencial em estabelecimentos. O sistema permite que operadores de guichê chamem senhas normais e preferenciais de forma organizada, exibindo as chamadas em um painel público para os clientes.

### Tecnologias Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP 7.4+
- **Banco de Dados:** MySQL
- **Servidor:** Apache (WAMP)

## Estrutura do Projeto

```
senha/
├── admin/          # Painel de administração
├── operador/       # Módulo do operador
├── painel/         # Painel público
├── includes/       # Arquivos de configuração e funções
├── assets/         # Arquivos de estilo (CSS)
├── docs/           # Documentação do sistema (incompleto)
├── criar_banco.php # Script para criação do banco de dados
├── index.php       # Página inicial (redireciona para login)
├── login.php       # Página de autenticação
├── logout.php      # Script de logout
├── prd.md          # Documento de requisitos do produto
└── README.md       # Documentação principal
```

## Módulos do Sistema

### 1. Administração (admin/)
Interface para configuração do sistema:
- Gerenciamento de guichês (cadastro, ativação, desativação, exclusão)
- Configuração das faixas de senhas (normal e preferencial)
- Reset do histórico de senhas chamadas

Arquivos principais:
- `index.php`: Interface principal de administração
- `acao_guiche.php`: Ações relacionadas aos guichês
- `acao_senhas.php`: Configuração das faixas de senhas
- `acao_reset.php`: Reset do histórico de senhas

### 2. Operador (operador/)
Interface para os operadores de guichê:
- Seleção de guichê
- Chamada de senhas normais e preferenciais
- Visualização da última senha chamada
- Histórico das últimas senhas chamadas

Arquivos principais:
- `index.php`: Interface principal do operador
- `selecionar_guiche.php`: Seleção de guichê
- `chamar_senha.php`: Lógica para chamar a próxima senha

### 3. Painel Público (painel/)
Interface exibida para os clientes:
- Exibição da senha atual chamada
- Lista das últimas senhas chamadas
- Atualização automática em tempo real

Arquivos principais:
- `index.php`: Interface do painel público
- `dados.php`: Endpoint que fornece dados em tempo real via AJAX

### 4. Autenticação
Sistema de autenticação para acesso às áreas restritas:
- Página de login
- Verificação de credenciais
- Controle de acesso unificado (todos os usuários autenticados podem acessar todas as áreas)
- Sistema de logout

## Banco de Dados

O sistema utiliza o banco de dados MySQL `senhas_atendimento` com as seguintes tabelas:

### Tabelas

1. **guiches**
   - `id`: Identificador único do guichê
   - `nome`: Nome do guichê
   - `status`: Status do guichê (1 = ativo, 0 = inativo)

2. **configuracoes**
   - `id`: Identificador único
   - `tipo_senha`: Tipo de senha ('normal' ou 'preferencial')
   - `numero_inicial`: Número inicial da faixa de senhas
   - `numero_final`: Número final da faixa de senhas

3. **senhas_chamadas**
   - `id`: Identificador único
   - `tipo_senha`: Tipo de senha ('normal' ou 'preferencial')
   - `numero_senha`: Número da senha chamada
   - `guiche_id`: ID do guichê que chamou a senha
   - `data_hora`: Data e hora da chamada

4. **usuarios**
   - `id`: Identificador único do usuário
   - `nome`: Nome completo do usuário
   - `login`: Nome de usuário para login
   - `senha`: Senha do usuário (armazenada como texto simples por simplicidade)
   - `nivel`: Nível de acesso ('admin' ou 'operador')
   - `ativo`: Status do usuário (1 = ativo, 0 = inativo)
   - `data_criacao`: Data e hora de criação do usuário

## Arquivos de Configuração e Funções

### includes/conexao_db.php
Arquivo de conexão com o banco de dados MySQL:
- Host: localhost
- Usuário: root
- Senha: (vazia)
- Banco: senhas_atendimento

### includes/funcoes.php
Funções auxiliares do sistema:
- `obterProximaSenha()`: Obtém a próxima senha disponível
- `registrarChamadaSenha()`: Registra a chamada de uma senha
- `obterUltimasSenhasChamadas()`: Obtém o histórico de senhas chamadas

### includes/autenticacao.php
Funções para controle de autenticação:
- `verificarAutenticacao()`: Verifica se o usuário está logado
- `obterNomeUsuario()`: Retorna o nome do usuário logado

### includes/menu_navegacao.php
Arquivo reutilizável com menu de navegação:
- Menu com botões para acesso rápido às principais áreas do sistema
- Botões: Administração, Operadores e Painel
- Informações do usuário logado e botão de sair
- Indicador visual para página atual ativa
- Estilizado com CSS para manter consistência visual

## Instalação e Configuração

1. Instalar o WAMP Server (ou equivalente)
2. Colocar os arquivos do sistema na pasta `www` do WAMP
3. Iniciar o WAMP Server
4. Acessar `http://localhost/senha/criar_banco.php` para criar o banco de dados
5. Acessar `http://localhost/senha/login.php` para fazer login no sistema

## Comandos Importantes

- **Criar banco de dados**: Acessar `http://localhost/senha/criar_banco.php`
- **Acessar página de login**: `http://localhost/senha/login.php`
- **Acessar administração**: `http://localhost/senha/admin/` (requer autenticação)
- **Acessar painel público**: `http://localhost/senha/painel/` (acesso livre)
- **Acessar interface do operador**: `http://localhost/senha/operador/` (requer autenticação)

## Convenções de Desenvolvimento

- O sistema segue os requisitos definidos no documento PRD (prd.md)
- Utiliza identidade visual da Polícia Civil de Santa Catarina
- Cores principais: vermelho institucional (#D50000) e dourado (#c9a43b)
- Design responsivo para diferentes dispositivos
- Atualização automática do painel público a cada 3 segundos

## Fluxo de Uso

1. **Acesso inicial**:
   - Usuário acessa o sistema e faz login
   - Sistema permite acesso a todas as áreas para qualquer usuário autenticado

2. **Configuração inicial**:
   - Cadastra os guichês
   - Define as faixas de senhas (normal e preferencial)

3. **Atendimento**:
   - Seleciona o guichê que irá operar
   - Chama próxima senha através da interface
   - Painel público é atualizado automaticamente
   - Cliente se dirige ao guichê indicado

## Documentação Disponível

- `README.md`: Visão geral e instruções de instalação
- `prd.md`: Documento de requisitos do produto completo
- Documentação técnica: Incompleta/ausente

## Considerações Técnicas

- O sistema foi projetado para funcionar em ambiente local (intranet)
- Não requer conexão com a internet
- Suporta múltiplos operadores simultaneamente
- Interface responsiva para diferentes tamanhos de tela
- Atualizações em tempo real via AJAX
- Sistema de autenticação baseado em sessões PHP
- Controle de acesso unificado (todos os usuários autenticados podem acessar todas as áreas)