# Yii2 app

## Sumário
  * [Descrição do projeto](#descrição-do-projeto)
  * [Funcionalidades](#funcionalidades)
  * [Como rodar a aplicação](#como-rodar-a-aplicação)
  * [Como derrubar a aplicação](#como-derrubar-a-aplicação)
  * [Documentação da API](#documentação-da-api)

## Descrição do projeto

<h4 align="justify">API desenvolvida para teste de desenvolvimento em Yii2 Framework</h4>
<p align="justify">Esta API permite o gerenciamento de clientes e produtos, utilizando autenticação baseada em tokens Bearer. Inclui cadastro e listagem de clientes e produtos, com validação de dados e paginação, tudo rodando em containers Docker.</p>

## Funcionalidades

### Autenticação
- [x] Comando para criação de usuários no sistema
- [x] POST /auth/login

### Clientes
- [x] GET /customers (Listar dos clientes com paginação)
- [x] POST /customers/create (Cadastro de cliente)

### Produtos (Products)
- [x] GET /products (Listar todos os produtos com paginação)
- [x] POST /products/create (Cadastro de produto)

## Como rodar a aplicação

No terminal, clone o projeto:

```
git clone git@github.com:thalis-freitas/yii2-app.git
```

Entre na pasta do projeto:

```
cd yii2-app
```

Certifique-se de que o Docker esteja em execução em sua máquina e construa as imagens:

```
docker compose build
```

Suba os containers:

```
docker compose up -d

```
Acesse o bash do app:

```
docker compose exec app bash

```
Rode o comando de inicialização:

```
php init

```
Escolha a opção [`0`] Development.

Instale as dependências:

```
composer install

```

Atualize o conteúdo do arquivo `/src/common/config/main-local.php` para:

```php
<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=yii2_db;dbname=yii2',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
    ],
];

```

### Configuração do banco de dados

Acesse o bash do banco de dados:

```
docker compose exec db bash

```

Entre no MySQL como root:

```
mysql -u root -p

```

Insira a senha `root`.

Altere o método de autenticação:

```sql
ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'root';
```

Saia do bash do db e entre no bash do app:
```
docker compose exec app bash

```

Execute as migrações:

```
php yii migrate

```
Semeie os dados de gêneros:
```
php yii seed/gender

```

## Como derrubar a aplicação

```
docker compose down
```

## Documentação da API

<div align="center">
  :construction: Em desenvolvimento...
</div>
