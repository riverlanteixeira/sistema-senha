# PRD: Sistema de Gerenciamento de Senhas de Atendimento

**Versão:** 1.0
**Data:** 08 de setembro de 2025

---

### 1. Visão Geral do Produto

#### 1.1. O Problema
O gerenciamento manual de filas de atendimento com senhas de papel pode ser ineficiente, propenso a erros e pouco transparente para os clientes que aguardam. A falta de um sistema centralizado dificulta a chamada de senhas, o direcionamento para guichês específicos e a gestão de atendimentos prioritários.

#### 1.2. A Solução
Um sistema web local (intranet) para gerenciamento de senhas de atendimento. A solução permitirá que operadores de guichê chamem senhas normais e preferenciais de forma organizada, exibindo as chamadas em um painel público. O sistema utilizará rolos de senhas pré-impressas, focando na simplicidade de implantação e uso em um ambiente sem acesso à internet.

#### 1.3. Personas
* **Administrador:** Responsável por configurar o sistema, cadastrar guichês e definir as faixas de senhas dos rolos.
* **Operador de Guichê:** Colaborador que realiza o atendimento e utiliza o sistema para chamar as próximas senhas da fila.
* **Cliente:** Pessoa que retira uma senha pré-impressa e aguarda ser chamada através do painel público.

#### 1.4. Escopo do Projeto
* **DENTRO DO ESCOPO:**
    * Sistema web responsivo para acesso via navegador em rede local (intranet).
    * Gerenciamento de múltiplos guichês (cadastro, ativação/desativação).
    * Controle de senhas normais e preferenciais com base em rolos pré-impressos.
    * Painel público para exibição das senhas chamadas.
    * Interface para operadores de guichê realizarem as chamadas.
    * Histórico simples de atendimentos.

* **FORA DO ESCOPO:**
    * Impressão de senhas pelo sistema (totem de autoatendimento).
    * Integração com sistemas externos.
    * Funcionalidades de agendamento.
    * Autenticação complexa de usuários com login e senha individuais.
    * Relatórios analíticos avançados.
    * Qualquer funcionalidade que exija conexão com a internet.

---

### 2. Requisitos Funcionais (Features)

#### 2.1. Módulo de Administração
* **Gerenciamento de Guichês:**
    * `(RF001)` O sistema deve permitir cadastrar múltiplos guichês.
    * `(RF002)` Cada guichê deve possuir um identificador único (ex: "Guichê 01").
    * `(RF003)` O administrador deve poder ativar ou desativar guichês.
    * `(RF004)` A interface deve exibir o status de cada guichê (Ativo/Inativo).
* **Gerenciamento de Senhas:**
    * `(RF006)` Permitir que o administrador defina a faixa de numeração dos rolos de senhas disponíveis (número inicial e final).
    * `(RF008)` O sistema deve suportar dois tipos de senha, conforme os rolos pré-impressos: Normal e Preferencial.
* **Configurações Gerais:**
    * `(RF017)` Fornecer um painel de configurações para o administrador.
    * Permitir o reset do sistema (reiniciar a contagem de senhas).

#### 2.2. Módulo do Operador de Guichê
* **Controle de Atendimento:**
    * `(RF009)` Cada operador deve ter uma interface com os botões "Chamar Próxima Normal" e "Chamar Próxima Preferencial".
    * `(RF010)` A interface do operador deve exibir a última senha chamada pelo seu guichê.
* **Histórico:**
    * `(RF012)` O sistema deve registrar um histórico simples das senhas chamadas por cada guichê.

#### 2.3. Módulo de Visualização (Painel Público)
* **Exibição de Chamadas:**
    * `(RF015)` Exibir em tela cheia a última senha chamada e o respectivo guichê.
    * Apresentar uma lista com as últimas 4 ou 5 senhas chamadas para referência.
* **Interface e Responsividade:**
    * `(RF018)` A interface do painel deve ser responsiva e se adaptar a diferentes tamanhos de tela (TVs, monitores).

---

### 3. Requisitos Não Funcionais

#### 3.1. Arquitetura e Tecnologia
* `(RNF001)` O sistema deve ser desenvolvido para rodar em um ambiente de servidor WAMP (Windows, Apache, MySQL, PHP).
* `(RNF002)` Utilizar banco de dados MySQL para persistência de dados.
* `(RNF003)` A interface web (frontend) deve ser desenvolvida com `HTML5`, `CSS3` e `JavaScript`. O uso do framework `Bootstrap` é recomendado.
* `(RNF003)` A lógica de negócio (backend) deve ser desenvolvida em `PHP` (versão 7.4 ou superior).
* `(RNF011)` As atualizações no painel público devem ocorrer em tempo real (ou quasi-real-time) via `AJAX` ou `WebSockets`.
* `(RNF004)` O sistema deve ser compatível com as versões mais recentes dos navegadores Google Chrome, Mozilla Firefox e Microsoft Edge.

#### 3.2. Desempenho
* `(RNF009)` O tempo de resposta para operações críticas (chamar senha, atualizar painel) não deve exceder 2 segundos.
* `(RNF010)` O sistema deve suportar até 50 operadores utilizando a plataforma simultaneamente sem degradação perceptível da performance.

#### 3.3. Usabilidade e Acessibilidade
* `(RNF012)` A interface deve ser simples e intuitiva, exigindo o mínimo de treinamento.
* `(RNF013)` No painel público, as fontes devem ser grandes, legíveis e de fácil visualização à distância.
* `(RNF014)` Utilizar cores de alto contraste no painel público para garantir boa visibilidade em diferentes condições de iluminação.

#### 3.4. Implantação e Rede
* `(RNF005)` O sistema deve operar exclusivamente em uma rede local (intranet).
* `(RNF007)` Não deve requerer conexão com a internet para seu funcionamento.
* `(RNF006)` Qualquer dispositivo (computador, tablet) conectado à mesma rede local deve poder acessar as interfaces do sistema (painel, operador, admin) pelo navegador.
* `(RNF008)` O acesso será feito através do endereço IP do servidor (ex: `http://192.168.1.100/senhas`).

---

### 4. Fluxos de Usuário

#### 4.1. Fluxo de Configuração Inicial (Administrador)
1.  O administrador acessa a tela administrativa.
2.  Cadastra os guichês que estarão em operação, definindo seus nomes (Guichê 1, Caixa, etc.).
3.  Acessa a área de configuração de senhas.
4.  Informa a faixa numérica inicial e final dos rolos de senhas (normal e preferencial) que serão utilizados.
5.  Salva as configurações. O sistema está pronto para operar.

#### 4.2. Fluxo de Atendimento (Operador e Cliente)
1.  O cliente chega e retira uma senha pré-impressa do rolo (Normal ou Preferencial).
2.  O operador de guichê acessa a tela de operação em seu computador.
3.  Para iniciar um novo atendimento, o operador clica em "Chamar Próxima Normal" ou "Chamar Próxima Preferencial".
4.  O sistema busca a próxima senha disponível na sequência configurada, marca-a como "chamada" e a associa ao guichê do operador.
5.  Instantaneamente, o painel público é atualizado, exibindo a senha chamada e o guichê correspondente de forma destacada, além de emitir um alerta sonoro.
6.  O cliente vê sua senha no painel e se dirige ao guichê.
7.  Ao finalizar o atendimento, o operador simplesmente chama a próxima senha, e o ciclo se repete. A senha anterior é movida para o histórico.

---

### 5. Critérios de Aceitação

#### 5.1. Funcionalidade Core
* O cadastro, ativação e desativação de guichês funciona corretamente.
* A configuração da faixa de senhas é salva e utilizada corretamente pelo sistema.
* Os botões de "Chamar Próxima" (Normal e Preferencial) funcionam para cada guichê de forma independente.
* O sistema atualiza o painel público em menos de 3 segundos após uma chamada.
* Os dados de configuração e histórico de chamadas persistem mesmo após o servidor ser reiniciado.

#### 5.2. Interface e Usabilidade
* A interface é responsiva e se adapta corretamente a telas de desktop e monitores/TVs (painel).
* O painel público é claramente legível a uma distância de 10 metros.
* As interfaces de administração e operação são intuitivas e fáceis de usar.

#### 5.3. Técnico e Rede
* O sistema opera corretamente em um ambiente WAMP padrão.
* Múltiplos operadores conseguem acessar e utilizar o sistema simultaneamente sem conflitos de dados.
* Qualquer dispositivo na mesma faixa de IP do servidor consegue acessar a URL do sistema com sucesso.