# Manual do Administrador - Sistema de Gerenciamento de Senhas

## Acesso ao Painel de Administração

Para acessar o painel de administração, abra um navegador web e digite o endereço:
```
http://[IP_DO_SERVIDOR]/senha/admin/
```

Exemplo: `http://192.168.1.100/senha/admin/`

## Configuração Inicial

### 1. Cadastro de Guichês

1. Na página de administração, localize a seção "Gerenciar Guichês"
2. No campo "Nome do Guichê", digite o nome do guichê (ex: "Guichê 1", "Caixa", "Reclamações")
3. Clique em "Adicionar Guichê"
4. O novo guichê aparecerá na lista com status "Ativo"

### 2. Ativação/Desativação de Guichês

- Para **desativar** um guichê, clique no botão "Desativar" ao lado do guichê desejado
- Para **ativar** um guichê desativado, clique no botão "Ativar" ao lado do guichê desejado
- Guichês desativados não aparecem na lista de operadores para chamada de senhas

### 3. Configuração de Faixas de Senhas

#### Senhas Normais
1. Na aba "Configurar Senhas", localize a seção "Senhas Normais"
2. Defina o "Número Inicial" (ex: 1)
3. Defina o "Número Final" (ex: 100)
4. Clique em "Salvar Configuração - Normal"

#### Senhas Preferenciais
1. Na mesma aba, localize a seção "Senhas Preferenciais"
2. Defina o "Número Inicial" (ex: 1)
3. Defina o "Número Final" (ex: 50)
4. Clique em "Salvar Configuração - Preferencial"

## Funcionalidades

### Gerenciamento de Guichês
- **Cadastro:** Adição de novos guichês ao sistema
- **Ativação/Desativação:** Controle de guichês operacionais
- **Visualização:** Lista completa de guichês e seus status

### Configuração de Senhas
- **Definição de Faixas:** Estabelecimento dos intervalos de numeração para senhas
- **Controle de Sequência:** Sistema automático de sequenciamento de senhas
- **Validação:** Verificação de disponibilidade dentro das faixas configuradas

## Boas Práticas

1. **Cadastro Antecipado:** Cadastre todos os guichês antes do início das operações
2. **Configuração de Faixas:** Defina faixas adequadas considerando o volume esperado de atendimentos
3. **Manutenção:** Desative guichês que não estão em uso para evitar confusão
4. **Monitoramento:** Verifique regularmente se as faixas de senhas estão adequadas à demanda