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
- [ ] Comando para criação de usuários no sistema
- [ ] POST /login

### Clientes
- [ ] GET /customers (Listar dos clientes com paginação)
- [ ] POST /customers/create (Cadastro de cliente)

### Produtos (Products)
- [ ] GET /products (Listar todos os produtos com paginação)
- [ ] POST /products/create (Cadastro de produto)

<div align="center">
  :construction: Em desenvolvimento...
</div>

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

## Como derrubar a aplicação

```
docker compose down
```

## Documentação da API
