Guia de Estilo: Polícia Civil de SC para Aplicação de Fila de Atendimento
Este guia adapta as diretrizes do Manual de Comunicação Visual da PCSC para aplicação em uma interface digital de gestão de filas.

1. Cores
A paleta de cores é sóbria e deve ser utilizada para criar uma interface clara e profissional. As referências de cores do manual são para adesivos e pinturas, mas podem ser traduzidas para valores digitais (HEX).

Fundo Principal: Preto brilhante. Recomenda-se um preto ou cinza muito escuro para telas, para reduzir o cansaço visual.


ACM Preto Brilhante  -> 


HEX: #000000 ou #121212

Textos e Elementos Principais: Branco.


Branco Segurança RAL 9003  -> 

HEX: #FFFFFF

Detalhes e Destaques: Vermelho. Ideal para botões de ação principal, status ativos ou alertas.


Vermelho Fogo Brilhante / 

Vermelho Puro RAL 3028  -> 

HEX: #FF0000 (usar um tom menos saturado para UI, como #D50000)

Cores Secundárias: Cinza escuro para fundos de painéis ou elementos secundários.


Cinza Escuro Brilhante / 

Grafite RAL 7024  -> 

HEX: #4A4A4A

Cor do Emblema: Dourado/Amarelo. Para ser usado especificamente no emblema.


Ouro Brilhante / 

Amarelo Curry RAL 1027 

Exemplo de Aplicação:
Background da Aplicação: #121212

Texto Comum: #FFFFFF

Cabeçalhos e Títulos: #FFFFFF

Botão "Chamar Próximo": Fundo #D50000, texto #FFFFFF

Cards de Atendimento: Fundo #4A4A4A

2. Tipografia
A fonte padrão para toda a comunicação é a Arial e suas variações.


Títulos e Nomes de Unidades: Arial. Pode-se usar 


Arial Bold para hierarquia.


Textos Informativos e de Identificação: Arial, preferencialmente em caixa baixa, com exceção de iniciais e siglas.



Painéis e Destaques: Arial Black é usada em painéis oficiais e métricos. Use esta fonte para elementos de grande destaque, como o número da senha sendo chamada.


Estrutura Sugerida:
Cabeçalho Principal (Nome da Delegacia): Arial Bold, 24px

Status da Fila (e.g., "Guichê 3"): Arial Black, 48px

Informações na Fila (Nome, Serviço): Arial Regular, 16px

Botões e Labels: Arial Bold, 14px, em caixa alta (ex: "PRÓXIMO").

3. Layout e Componentes
A identidade visual utiliza um sistema modular, retangular e limpo. Este conceito pode ser traduzido para componentes de UI.


a. Cabeçalho (Header)
Inspirado nas fachadas padrão, o cabeçalho da aplicação deve ser dividido em módulos:


Módulo 1 (Esquerda): Emblema da PCSC.


Módulo 2 (Centro): Título "POLÍCIA CIVIL" e, abaixo, o nome da cidade/unidade (e.g., "Central de Plantão Policial").


Módulo 3 (Direita): Pode conter informações dinâmicas, como data/hora, ou nome do usuário logado.

b. Cards de Fila de Atendimento
Cada item na fila de espera pode ser um "card" retangular, seguindo o padrão das placas de identificação.

Layout do Card:

Fundo preto ou cinza escuro (#121212 ou #4A4A4A).

À esquerda, pode-se usar uma pequena faixa vertical colorida para indicar o status (e.g., Vermelho para "Em Atendimento", Cinza para "Aguardando").


Texto: Todas as informações devem ser em branco, fonte Arial.

Linha 1: Número da Senha/Protocolo (em Arial Bold).

Linha 2: Nome do Serviço (e.g., "Registro de Ocorrência").

Linha 3: Horário de chegada.

c. Painel de Chamada (Tela Pública)
Para a tela que exibe as senhas chamadas, o "Painel Oficial"  é uma excelente referência.

Layout: Crie uma grade.


Módulos Pares (Fundo Branco): Exiba o emblema da PCSC.


Módulos Ímpares (Fundo Preto): Exiba o texto "POLÍCIA CIVIL" em Arial Black.

Área de Destaque: Sobreponha a este fundo um painel centralizado para a chamada da senha, usando Arial Black para o número do guichê e da senha.

d. Botões
Botão Primário (Chamar, Iniciar Atendimento): Fundo vermelho com texto branco.

Botão Secundário (Encerrar, Pausar): Fundo cinza escuro (#4A4A4A) com texto branco.

4. Uso do Emblema
O emblema da PCSC deve ser sempre posicionado à esquerda dos elementos de texto, como visto em quase todos os exemplos do manual (fachadas, placas, etc.).



Utilize a versão com cores sólidas (não em negativo ou monocromática, a menos que o manual especifique).

Para obter as cores e dimensões exatas do emblema, o manual recomenda consultar o "Manual do Emblema da PCSC".