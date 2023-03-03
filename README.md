# Teste Frontend 03

Olá, muito obrigado por participar do processo de contratação da Seox. Este repositório contém as instruções de entrega do seu teste. Siga elas da forma mais precisa o possível para conseguirmos avaliar você de forma adequada.

## Por onde começar

1. Faça um fork deste repositório e utilize-o para realizar a implementação da solução.
2. Utilize o README para adicionar detalhamentos de como executar o seu projeto, além de comentários livres que você queira adicionar.

## Requisitos

Você deverá construir uma página responsiva seguindo as orientações visuais dos arquivos em Figma listados abaixo. Nele, você encontrará o layout da versão desktop e mobile, seguido do styleguide com todos os elementos do projeto.

Para um melhor entendimento da proposta, abaixo seguem também os links do Protótipo Navegável, onde você poderá ver as animações e interações que deverão estar presentes no resultado final.

O teste consiste basicamente na criação de uma section com um carrossel, listando postagens dinâmicas vindas da REST API de uma aplicação WP (WordPress). (Detalhes do serviço REST estão descritos abaixo).

Atenção: A fidelidade da aplicação com o Figma e o protótipo navegável é de suma importância. Busque o máximo de fidelidade possível.

### Protótipo navegável

- Desktop: https://www.figma.com/proto/6S1YIPxnMcWp4AE4Al9SRS/Front-End-Test?page-id=1489%3A1836&node-id=1489%3A1838&viewport=1016%2C512%2C0.61&scaling=min-zoom
- Mobile: https://www.figma.com/proto/6S1YIPxnMcWp4AE4Al9SRS/Front-End-Test?page-id=1489%3A1837&node-id=1489%3A2124&viewport=941%2C700%2C1.02&scaling=scale-down

### Arquivos Figma

- Figma: https://www.figma.com/file/6S1YIPxnMcWp4AE4Al9SRS/Front-End-Test?t=znQ7nXaNHGcHxHCe-1

### Serviço REST de listagem de posts

Preparamos uma aplicação WP com uma listagem de posts previamente configurada. A seguinte documentação detalha como utilizar a REST API do WP para listar os posts necessários para dinamização do carrossel do teste.

Documentação: https://developer.wordpress.org/rest-api/reference/posts/

Aplicação WP: https://teste-frontend.seox.com.br/

Nota: Tradicionalmente para buscar a imagem destacada de um post você precisaria fazer uma requisição REST somente para retornar a url da imagem. Entretanto, é possível listar as URLs da imagem destacada de posts na requisição inicial através da query string `?_embed`. Essa query string adiciona o atributo `wp:featuredmedia` contendo as URLs da imagem destacada.

### Requisitos não funcionais

Requisitos não funcionais são aqueles referentes a especificações das tecnologias que devem ser utilizadas no desenvolvimento da solução. Para esse projeto, utilize SASS como pré-processador.

A dinamização dos posts através do serviço REST pode ser feito através do PHP ou JS.

Procure estruturar o Styleguide de forma isolada e reutilizável. Iremos avaliar positivamente um projeto bem estruturado.

## Entrega final

A entrega final será composta por dois artefatos:

1. Enviar, via email rh@seox.com.br, o link do repositório originado deste (fork) com os códigos da solução implementada.
2. Você deve hospedar a aplicação e disponibilizar um domínio para testes. Sugerimos a utilização do Gitlab pages para hospedar a solução implementada. Nosso setor de QA (Quality Assurance) vai utilizar essa página para avaliar o seu trabalho visual.

## O que será avaliado

1. Fidelidade do layout.
2. Qualidade do código (organização dos códigos, componentização e responsividade).
3. Organização dos arquivos.
4. Utilização do Git.
5. SEO Técnico (CWV).

## Opcionais de Valor

1. Componentizar elementos em PHP ou PHP/WordPress.
2. Utilizar o framework Bootstrap.
3. Fazer o carrossel sem biblioteca externa, pode utilizar JS ou jQuery.

## Diretrizes

1. O teste deverá ser desenvolvido utilizando SASS.
2. Consumir a REST API (em JS ou PHP) e dinamizar os cards do carrossel.
3. Inserir comentários inteligentes para diferenciação de componentes
4. Subir em um ambiente online para que possa ser enviado pra gente.

## Observações importantes

- Vamos avaliar também o seu capricho com o Git.
- Caso você tenha algum problema com a entrega, por favor entrar em contato pelo email rh@seox.com.br.
- Nosso time está disponível para tirar dúvidas. Para isso, entre em contato pelo email rh@seox.com.br.

## Notas extras

- Nosso time de QA visual é conhecido como "Pixel Hunters". Capriche na fidelidade com o Figma.

## Anotações

- Para os ícones, optei por usar SVG em base64, já que são poucos ícones e não vejo necessidade de carregar uma biblioteca inteira.
