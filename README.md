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

As requisições da API configuradas com o [Bruno](https://www.usebruno.com/) estão disponíveis no repositório [Yii2 App Requests](https://github.com/thalis-freitas/yii2-app-requests).

### Parâmetros de consulta para Endpoints de listagem com paginação e ordenação

| Nome            | Tipo      | Descrição                       |
| --------------- | --------- | ------------------------------- |
| `page`          | Inteiro   | Número da página desejada.      |
| `per-page`      | Inteiro   | Quantidade de itens por página. |
| `sort`          | String	  | Campo pelo qual a lista será ordenada. Utilize o prefixo - para ordem decrescente. Ex: -id. |

## Autenticação

### Login

**Endpoint: POST /auth/login**

#### Parâmetros de requisição

| Nome       | Tipo      | Descrição           |
| ---------- | --------- | ------------------- |
| `login`    | String    | Login do usuário.   |
| `password` | String    | A senha do usuário. |

#### Exemplo de requisição

```json
{
  "login": "user",
  "password": "pass"
}
```

Retorno `200` (Sucesso)

```json
{
  "token": "Hr72NHWd-R2S_I_htsXBOYV6Rcqb2nsr",
  "user": {
    "id": 2,
    "username": "user",
    "login": "user",
    "status": 10
  }
}
```

Retorno `401` (Não autorizado)

Se o login ou a senha forem inválidos, o endpoint retornará um código de status `401 Unauthorized` com informações sobre o erro de validação.

```json
{
  "name": "Unauthorized",
  "message": "Invalid login or password.",
  "code": 0,
  "status": 401,
  "type": "yii\\web\\UnauthorizedHttpException"
}
```

## Clientes

### Listar clientes

**Endpoint: GET /customers**

#### Exemplo de requisição

GET /customers?per-page=20&page=1

#### Retorno `200` (Sucesso)

```json
[
  {
    "id": 9,
    "name": "João da Silva",
    "registration_number": "41045733024",
    "photo": "http://localhost:8080/assets/uploads/photos/image1.png",
    "address": {
      "id": 9,
      "zip_code": "03318000",
      "street": "Rua Serra de Bragança",
      "number": "123",
      "city": "São Paulo",
      "state": "SP",
      "complement": "Vila Gomes Cardim"
    },
    "gender": {
      "id": 2,
      "name": "Masculino"
    }
  },
  {
    "id": 10,
    "name": "Ana Lima",
    "registration_number": "44492032088",
    "photo": "http://localhost:8080/assets/uploads/photos/image2.png",
    "address": {
      "id": 10,
      "zip_code": "62011140",
      "street": "Rua Domingos Olímpio",
      "number": "99",
      "city": "Sobral",
      "state": "CE",
      "complement": "Centro"
    },
    "gender": {
      "id": 1,
      "name": "Feminino"
    }
  }
]
```
- Para obter os produtos associados a cada cliente, adicione o parâmetro `expand=products` na consulta.

### Cadastro de cliente

**Endpoint: POST /customers/create**

#### Parâmetros de requisição

| Nome                  | Tipo      | Descrição                |
| ---------------       | --------- | ------------------------ |
| `name`                | String    | O nome do cliente.       |
| `registration_number` | String    | CPF do cliente.          |
| `address[zip_code]`   | String    | CEP do cliente.          |
| `address[street]`     | String    | Rua do cliente.          |
| `address[number]`     | String    | Número da residência.    |
| `address[city]`       | String    | Cidade do cliente.       |
| `address[state]`      | String    | Estado do cliente.       |
| `address[complement]` | String    | Complemento do endereço. |
| `gender_id`           | Inteiro   | ID do gênero do cliente. |
| `photo`               | File	    | Foto do cliente.         |

#### Opções de gênero

| ID  | Gênero      |
| --- | ----------- |
| `1` | Feminino    |
| `2` | Masculino   |
| `3` | Não binário |
| `4` | Outro       |

#### Exemplo de requisição

```multipart/form
{
  "name": "Ana Lima",
  "registration_number": "44492032088",
  "address[zip_code]": "62011140",
  "address[street]": "Rua Domingos Olímpio",
  "address[number]": "99",
  "address[city]": "Sobral",
  "address[state]": "CE",
  "address[complement]": "Centro",
  "gender_id": 1,
  "photo": (file)
}
```

Retorno `200` (Sucesso)

```json
{
  "id": 12,
  "name": "Ana Lima",
  "registration_number": "44492032088",
  "photo": "http://localhost:8080/assets/uploads/photos/foto5.jpeg",
  "address": {
    "id": 12,
    "zip_code": "62011140",
    "street": "Rua Domingos Olímpio",
    "number": "99",
    "city": "Sobral",
    "state": "CE",
    "complement": "Centro"
  },
  "gender": {
    "id": 1,
    "name": "Feminino"
  }
}
```

Retorno `422` (Erro de validação)

```json
{
  "name": "Unprocessable entity",
  "message": "{\"registration_number\":[\"O CPF deve ter 11 digitos\"]}",
  "code": 0,
  "status": 422,
  "type": "yii\\web\\UnprocessableEntityHttpException"
}
```

## Produtos

### Listar produtos

**Endpoint: GET /products**

#### Exemplo de requisição

GET /products?per-page=20&page=1

#### Retorno `200` (Sucesso)

```json
[
  {
    "id": 5,
    "name": "Produto 10",
    "price": "99.90",
    "photo": "http://localhost:8080/assets/uploads/photos/foto.jpeg"
  },
  {
    "id": 6,
    "name": "Produto 22",
    "price": "15.00",
    "photo": "http://localhost:8080/assets/uploads/photos/foto.jpeg"
  }
]
```

- Para obter o cliente associado ao produto, adicione o parâmetro `expand=customer` na consulta.

- Para filtrar os produtos por cliente, adicione o parâmetro `customerId=<id_do_cliente>` na consulta.

### Cadastro de produto

**Endpoint: POST /products/create**

#### Parâmetros de requisição

| Nome          | Tipo      | Descrição                |
| ------------- | --------- | ------------------------ |
| `name`        | String    | Nome do produto.         |
| `price`       | Decimal   | Preço do produto.        |
| `customer_id` | Integer   | Id do cliente detentor do produto. |
| `photo`       | File      | Foto do produto.         |

#### Exemplo de requisição

```multipart/form
{
  "name": "Produto 10",
  "price": "15.00",
  "customer_id": "1",
  "photo": (file)
}
```

Retorno `200` (Sucesso)

```json
{
  "id": 7,
  "name": "Produto 10",
  "price": "15.00",
  "photo": "http://localhost:8080/assets/uploads/photos/product.jpeg"
}
```

Retorno `422` (Erro de Validação)

```json
{
  "name": "Unprocessable entity",
  "message": "{\"photoFile\":[\"Sao permitidos somente arquivos com as seguintes extensoes: png, jpg, jpeg.\"]}",
  "code": 0,
  "status": 422,
  "type": "yii\\web\\UnprocessableEntityHttpException"
}
```
