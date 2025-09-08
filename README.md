# Sistema de Gerenciamento de Senhas

Sistema web para gerenciamento de senhas de atendimento presencial em estabelecimentos, desenvolvido em PHP com MySQL.

## Descrição

O Sistema de Gerenciamento de Senhas permite otimizar o atendimento presencial através do gerenciamento eficiente de filas de senhas. O sistema possibilita que operadores de guichê chamem senhas normais e preferenciais de forma organizada, exibindo as chamadas em um painel público para os clientes.

## Funcionalidades

- Cadastro e gerenciamento de guichês
- Configuração de faixas de senhas (normal e preferencial)
- Interface para chamada de senhas pelos operadores
- Painel público para exibição das senhas chamadas
- Histórico de senhas chamadas
- Atualização em tempo real do painel público

## Tecnologias Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
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
├── docs/           # Documentação do sistema
├── criar_banco.php # Script para criação do banco de dados
└── index.php       # Página inicial
```

## Instalação

1. Instale o WAMP Server (ou equivalente)
2. Coloque os arquivos do sistema na pasta `www` do WAMP
3. Inicie o WAMP Server
4. Acesse `http://localhost/senha/criar_banco.php` para criar o banco de dados
5. Acesse `http://localhost/senha/admin/` para configurar o sistema

Para instruções detalhadas, consulte [Guia de Instalação](docs/guia_instalacao.md).

## Documentação

A documentação completa do sistema está disponível na pasta `docs/`:

- [Visão Geral](docs/visao_geral.md)
- [Guia de Instalação](docs/guia_instalacao.md)
- [Manual do Administrador](docs/manual_administrador.md)
- [Manual do Operador](docs/manual_operador.md)
- [Manual do Painel Público](docs/manual_painel.md)
- [Documentação Técnica](docs/documentacao_tecnica.md)

## Licença

Este projeto é desenvolvido para uso interno e não possui uma licença específica definida.

## Desenvolvimento

Este sistema foi desenvolvido seguindo as especificações do PRD (Product Requirements Document) e está pronto para uso em ambiente de produção.