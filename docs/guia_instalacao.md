# Guia de Instalação - Sistema de Gerenciamento de Senhas

## Requisitos do Sistema

Antes de instalar o sistema, verifique se o servidor atende aos seguintes requisitos:

### Servidor
- Windows 7/8/10/11 ou Windows Server 2008+
- WAMP Server 3.2+ (ou equivalente)
  - Apache 2.4+
  - PHP 7.4+
  - MySQL 5.7+
- 1 GB de espaço em disco disponível
- 1 GB de RAM (recomendado)

### Rede
- Conexão de rede local (intranet)
- Endereço IP fixo para o servidor (recomendado)

## Instalação do WAMP

Se você ainda não tem o WAMP instalado:

1. Baixe o WAMP Server em: https://www.wampserver.com/
2. Execute o instalador como administrador
3. Siga as instruções do assistente de instalação
4. Reinicie o computador se solicitado

## Configuração do Banco de Dados

### 1. Iniciar o WAMP
1. Inicie o WAMP Server
2. Aguarde até que o ícone fique verde (indicando que todos os serviços estão rodando)

### 2. Criar o Banco de Dados
1. Abra um navegador e acesse: `http://localhost/senha/criar_banco.php`
2. A página mostrará o progresso da criação do banco de dados e tabelas
3. Verifique se todas as etapas foram concluídas com sucesso

### 3. Adicionar Dados de Exemplo (Opcional)
1. Acesse: `http://localhost/senha/adicionar_dados_exemplo.php`
2. A página confirmará que os dados de exemplo foram adicionados

## Configuração do Sistema

### 1. Acesso ao Painel de Administração
1. Abra um navegador e acesse: `http://localhost/senha/admin/`
2. Você verá a interface de administração

### 2. Cadastro de Guichês
1. Na seção "Gerenciar Guichês", digite o nome do guichê no campo apropriado
2. Clique em "Adicionar Guichê"
3. Repita para todos os guichês necessários

### 3. Configuração de Faixas de Senhas
1. Na aba "Configurar Senhas":
   - Defina a faixa para senhas normais (inicial e final)
   - Defina a faixa para senhas preferenciais (inicial e final)
2. Clique em "Salvar Configuração" para cada tipo

## Teste do Sistema

### 1. Módulo do Operador
1. Acesse: `http://localhost/senha/operador/`
2. Verifique se os guichês cadastrados aparecem corretamente
3. Teste a chamada de uma senha clicando em "Chamar Próxima Normal"

### 2. Painel Público
1. Acesse: `http://localhost/senha/painel/`
2. Verifique se o painel carrega corretamente
3. Após chamar uma senha, confirme se ela aparece no painel

## Configuração de Rede

### 1. Acesso por Outros Dispositivos
Para acessar o sistema de outros dispositivos na rede local:

1. Descubra o endereço IP do servidor (ex: 192.168.1.100)
2. Acesse de outros dispositivos usando: `http://192.168.1.100/senha/`

### 2. Firewall
Certifique-se de que o firewall do Windows permite conexões na porta 80 (HTTP).

## Solução de Problemas

### Problemas Comuns

#### O WAMP não inicia (ícone vermelho ou laranja)
1. Verifique se as portas 80 e 3306 estão livres
2. Tente reiniciar o WAMP
3. Reinicie o computador

#### Erro de conexão com o banco de dados
1. Verifique se o MySQL está rodando (ícone verde)
2. Confirme as credenciais em `includes/conexao_db.php`
3. Execute novamente o script `criar_banco.php`

#### Páginas não carregam
1. Verifique se o Apache está rodando (ícone verde)
2. Confirme se os arquivos estão na pasta `www` do WAMP
3. Verifique as permissões de acesso aos arquivos

#### Painel público não atualiza
1. Verifique se o JavaScript está habilitado no navegador
2. Confirme se não há erros no console do navegador (F12)
3. Verifique a conexão de rede

### Logs de Erro
- Logs do Apache: `C:\wamp64\logs\apache_error.log`
- Logs do PHP: `C:\wamp64\logs\php_error.log`

## Manutenção

### Backup do Banco de Dados
Para fazer backup do banco de dados:

1. Acesse o phpMyAdmin: `http://localhost/phpmyadmin/`
2. Selecione o banco de dados `senhas_atendimento`
3. Clique em "Exportar" e siga as instruções

### Atualização do Sistema
Para atualizar o sistema:

1. Faça backup do banco de dados
2. Faça backup dos arquivos atuais
3. Substitua os arquivos pelos novos
4. Execute scripts de migração, se necessário

## Suporte

Para suporte adicional, consulte a documentação completa em:
- `docs/visao_geral.md`
- `docs/manual_administrador.md`
- `docs/manual_operador.md`
- `docs/manual_painel.md`
- `docs/documentacao_tecnica.md`