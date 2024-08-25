# Comercialize

O Comercialize é um projeto desenvolvido com Laravel 11, usando o banco de dados MySQL. O front-end utiliza o Laravel Blade e Framework Bootstrap 5. Ele possui funcionalidades de CRUD para vendas, produtos, categorias de produtos e usuários, abrangendo controle de estoque, relatórios e métricas de vendas.

O projeto conta com 3 tipos de usuários: administrador, vendedor e cliente. 
O administrador é responsável por gerenciar os produtos, categorias de produtos e usuários, além de visualizar relatórios e métricas de vendas. 
O vendedor é responsável por realizar vendas e visualizar relatórios e as próprias métricas de venda. 
O cliente é habilitado para visualizar os próprios dados e navegar pelos produtos.

## Instalação

A instalação do Comercialize pode ser feita manualmente utilizando o Composer ou através do Docker Compose gerado pelo Laravel Sail. Ou ainda, você pode optar por testar a aplicação já hospedada na Oracle Cloud Infrastructure, acessando o endereço [http://comercialize.hugobsan.me](http://comercialize.hugobsan.me).

### Instalação manual com Composer

1. Clone o repositório do Comercialize para o seu ambiente local.
2. Navegue até o diretório do projeto.
3. Execute o comando `composer install` para instalar as dependências.
4. Crie um arquivo `.env` baseado no arquivo `.env.example` e configure as variáveis de ambiente necessárias.
5. Execute o comando `php artisan key:generate` para gerar a chave de criptografia.
6. Execute o comando `php artisan storage:link` para criar o link simbólico para o diretório de armazenamento.
6. Execute o comando `php artisan migrate --seed` para executar as migrações do banco de dados.
7. Execute o comando `php artisan serve` para iniciar o servidor de desenvolvimento.

### Instalação com Docker Compose

1. Clone o repositório do Comercialize para o seu ambiente local.
2. Navegue até o diretório do projeto.
3. Execute o comando `docker-compose up -d --build` para iniciar os containers do Docker.
4. Acesse o projeto através do endereço `http://localhost:8000`.

## Uso

Após a instalação, você poderá acessar o Comercialize através do seu navegador. O projeto possui uma interface intuitiva que permite a realização de operações de vendas, gerenciamento de produtos, categorias de produtos e usuários, além de fornecer segurança no controle de estoque, relatórios e métricas de vendas para os vendedores e clientes.

Abaixo temos a lista de usuários padrão criados durante a execução do comando `php artisan migrate --seed`:

### Administrador
- E-mail: test@example.com
- Senha: password

### Vendedor
- E-mail: seller@example.com
- Senha: password

### Cliente
- E-mail: costumer@example.com
- Senha: password

O projeto também conta com disparos de e-mail para determinados eventos. Caso esteja em ambiente de desenvolvimento ou no docker, recomenda-se a utilização do Mailhog para capturar os e-mails enviados. No Laravel Sail, o Mailhog já está configurado e pode ser acessado através do endereço `http://localhost:8025`. Na aplicação hospedada, os e-mails são enviados normalmente para os destinatários.

## Contribuição

Contribuições são bem-vindas!