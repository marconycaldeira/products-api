# API de Produtos
## Funcionalidades
#### Usuários

- Cadastro de usuários;
- Autenticação utilizando JWT;

#### Produtos

- Listagem;
- Cadastro;
	- Produtos com variação de cores;
	- Produtos sem variação de cores;
- Edição;
- Exclusão.

## Instalação

1. Clonar este repositório `git clone https://github.com/marconycaldeira/products-api`;
2. Criar um banco de dados;
3. Entrar no diretório do projeto e executar o comando `composer install`;
4. Criar um arquivo **.env** na raiz do projeto (utilize o conteúdo do arquivo **.env.example**);
4.1. Configurar as variáveis de conexão com do seu banco de dados
`DB_CONNECTION=[driver do banco], DB_HOST=[host do banco]`
`DB_PORT=[porta do banco]`
`DB_DATABASE=[nome do banco de dados]`
`DB_USERNAME=[usuário do banco de dados]`
`DB_PASSWORD=[senha do banco de dados]`
5. Executar o comando `php artisan key:generate`;
6. Executar o comando `php artisan jwt:secret`;
7. Executar o comando `php artisan migrate`;

## Utilização
### Cadastro

Basta realizar uma requisição do tipo `POST` para a rota `[url de sua aplicação]/api/user` enviando os seguintes dados:
```javascript
{ 
	name: "nome do usuário",
	email: "email do usuário",
	password: "senha do usuário",
	password_confirmation: "confirmação da senha do usuário"
}
```
Se a requisição funcionar, você terá como resposta algo parecido com isso:
```javascript
{ 
    name: "Marcony Caldeira",
    email: "marconycaldeira@gmail.com",
    updated_at: "2020-05-27T19:34:46.000000Z",
    created_at: "2020-05-27T19:34:46.000000Z",
    id: 2
}
```
### Autenticação
Basta realizar uma requisição do tipo `POST` para a rota `[url de sua aplicação]/api/auth/login` enviando os seguintes dados:
```javascript
{ 
	email: "email do usuário",
	password: "senha do usuário",
}
```
Se a requisição funcionar, você terá como resposta algo parecido com isso:
```javascript
{ 
    access_token: "...",
    token_type: "bearer",
    expires_in: 3600
}
```
**Observação: ** você precisará deste token para utilizar os end-points dos produtos

### Produtos
#### Criação
**Observação: lembre de adicionar o access_token ao cabeçalho da requisição (Authorization Bearer [access_token])**

**1. Produtos sem variação de cores:**

Basta realizar uma requisição do tipo `POST` para a rota `[url de sua aplicação]/api/products` enviando os seguintes dados:
```javascript
{ 
	slug: "slug-do-produto",
	name: "Nome do Produto",
	initial_inventary: 100, //estoque inicial
	actual_inventary: 100, //estoque atual
	price: 44.90 //valor unitário do produto
	hasVariation: false //informa se o produto possui variações
}
```
Se a requisição funcionar, você terá como resposta algo parecido com isso:
```javascript
{
    slug: "camisa-adidas",
    name: "Camisa Adidas",
    description: null,
    created_by: 2,
    updated_at: "2020-05-27T19:46:43.000000Z",
    created_at: "2020-05-27T19:46:43.000000Z",
    id: 4,
    variations: [
        {
            id: 5,
            name: "default",
            type: null,
            initial_inventary: 100,
            actual_inventary: 100,
            price: 44.90,
            created_by: {
                id: 2,
                name: "Marcony Caldeira",
                email: "marconycaldeira@gmail.com",
                email_verified_at: null,
                created_at: "2020-05-27T19:34:46.000000Z",
                updated_at: "2020-05-27T19:34:46.000000Z",
                deleted_at: null
            },
            product_id: 4,
            created_at: "2020-05-27T19:46:43.000000Z",
            updated_at: "2020-05-27T19:46:43.000000Z",
            deleted_at: null
        }
    ]
}
```
**2. Produtos com variação de cores:**

Basta realizar uma requisição do tipo `POST` para a rota `[url de sua aplicação]/api/products` enviando os seguintes dados:
```javascript
{ 
	slug: "slug-do-produto",
	name: "Nome do Produto",
	hasVariation: true, //informa se o produto possui variações
	variations:[
	{
		name: "Azul",
		type: 1,  //1 = Cor, 2 = Tamanho
		initial_inventary: 100, //estoque inicial
		actual_inventary: 100, //estoque atual
		price: 44.90 //valor unitário do produto
	},
	{
		name: "Preta",
		type: 1,  //1 = Cor, 2 = Tamanho
		initial_inventary: 100, //estoque inicial
		actual_inventary: 100, //estoque atual
		price: 45.90 //valor unitário do produto
	},
]
}
```
Se a requisição funcionar, você terá como resposta algo parecido com isso:
```javascript
{
    slug: "camisa-adidas",
    name: "Camisa Adidas",
    description: null,
    created_by: 2,
    updated_at: "2020-05-27T19:46:43.000000Z",
    created_at: "2020-05-27T19:46:43.000000Z",
    id: 4,
    variations: [
        {
            id: 5,
            name: "Azl",
            type: null,
            initial_inventary: 100,
            actual_inventary: 100,
            price: 44.90,
            created_by: {
                id: 2,
                name: "Marcony Caldeira",
                email: "marconycaldeira@gmail.com",
                email_verified_at: null,
                created_at: "2020-05-27T19:34:46.000000Z",
                updated_at: "2020-05-27T19:34:46.000000Z",
                deleted_at: null
            },
            product_id: 4,
            created_at: "2020-05-27T19:46:43.000000Z",
            updated_at: "2020-05-27T19:46:43.000000Z",
            deleted_at: null
        },
		{
            id: 6,
            name: "Preta",
            type: null,
            initial_inventary: 100,
            actual_inventary: 100,
            price: 45.90,
            created_by: {
                id: 2,
                name: "Marcony Caldeira",
                email: "marconycaldeira@gmail.com",
                email_verified_at: null,
                created_at: "2020-05-27T19:34:46.000000Z",
                updated_at: "2020-05-27T19:34:46.000000Z",
                deleted_at: null
            },
            product_id: 4,
            created_at: "2020-05-27T19:46:43.000000Z",
            updated_at: "2020-05-27T19:46:43.000000Z",
            deleted_at: null
        }
    ]
}
```
#### Edição
**Observação: lembre de adicionar o access_token ao cabeçalho da requisição (Authorization Bearer [access_token])**

**1. Produtos sem variação de cores:**

Basta realizar uma requisição do tipo `PUT` para a rota `[url de sua aplicação]/api/products/[id do produto]` enviando os seguintes dados:
```javascript
{ 
	slug: "slug-do-produto",
	name: "Nome do Produto",
	initial_inventary: 100, //estoque inicial
	actual_inventary: 100, //estoque atual
	price: 44.90 //valor unitário do produto
	hasVariation: false //informa se o produto possui variações
}
```
Se a requisição funcionar, você terá como resposta algo parecido com isso:
```javascript
{
    slug: "camisa-adidas",
    name: "Camisa Adidas",
    description: null,
    created_by: 2,
    updated_at: "2020-05-27T19:46:43.000000Z",
    created_at: "2020-05-27T19:46:43.000000Z",
    id: 4,
    variations: [
        {
            id: 5,
            name: "default",
            type: null,
            initial_inventary: 100,
            actual_inventary: 100,
            price: 44.90,
            created_by: {
                id: 2,
                name: "Marcony Caldeira",
                email: "marconycaldeira@gmail.com",
                email_verified_at: null,
                created_at: "2020-05-27T19:34:46.000000Z",
                updated_at: "2020-05-27T19:34:46.000000Z",
                deleted_at: null
            },
            product_id: 4,
            created_at: "2020-05-27T19:46:43.000000Z",
            updated_at: "2020-05-27T19:46:43.000000Z",
            deleted_at: null
        }
    ]
}
```
**2. Produtos com variação de cores:**

Basta realizar uma requisição do tipo `PUT` para a rota `[url de sua aplicação]/api/products/[id do produto]` enviando os seguintes dados:
```javascript
{ 
slug: "slug-do-produto",
name: "Nome do Produto",
hasVariation: true, //informa se o produto possui variações
variations:[
	{
		name: "Azul",
		type: 1,  //1 = Cor, 2 = Tamanho
		initial_inventary: 100, //estoque inicial
		actual_inventary: 100, //estoque atual
		price: 44.90 //valor unitário do produto
	},
	{
		name: "Preta",
		type: 1,  //1 = Cor, 2 = Tamanho
		initial_inventary: 100, //estoque inicial
		actual_inventary: 100, //estoque atual
		price: 45.90 //valor unitário do produto
	},
]
}
```
Se a requisição funcionar, você terá como resposta algo parecido com isso:
```javascript
{
    slug: "camisa-adidas",
    name: "Camisa Adidas",
    description: null,
    created_by: 2,
    updated_at: "2020-05-27T19:46:43.000000Z",
    created_at: "2020-05-27T19:46:43.000000Z",
    id: 4,
    variations: [
        {
            id: 5,
            name: "Azl",
            type: null,
            initial_inventary: 100,
            actual_inventary: 100,
            price: 44.90,
            created_by: {
                id: 2,
                name: "Marcony Caldeira",
                email: "marconycaldeira@gmail.com",
                email_verified_at: null,
                created_at: "2020-05-27T19:34:46.000000Z",
                updated_at: "2020-05-27T19:34:46.000000Z",
                deleted_at: null
            },
            product_id: 4,
            created_at: "2020-05-27T19:46:43.000000Z",
            updated_at: "2020-05-27T19:46:43.000000Z",
            deleted_at: null
        },
		{
            id: 6,
            name: "Preta",
            type: null,
            initial_inventary: 100,
            actual_inventary: 100,
            price: 45.90,
            created_by: {
                id: 2,
                name: "Marcony Caldeira",
                email: "marconycaldeira@gmail.com",
                email_verified_at: null,
                created_at: "2020-05-27T19:34:46.000000Z",
                updated_at: "2020-05-27T19:34:46.000000Z",
                deleted_at: null
            },
            product_id: 4,
            created_at: "2020-05-27T19:46:43.000000Z",
            updated_at: "2020-05-27T19:46:43.000000Z",
            deleted_at: null
        }
    ]
}
```
#### Exclusão
**Observação: lembre de adicionar o access_token ao cabeçalho da requisição (Authorization Bearer [access_token])**

Basta realizar uma requisição do tipo `DELETE` para a rota `[url de sua aplicação]/api/products/[id do produto]`

Se a requisição funcionar, você terá como resposta algo parecido com isso:
`true`

#### Mostrar produto
**Observação: lembre de adicionar o access_token ao cabeçalho da requisição (Authorization Bearer [access_token])**

Basta realizar uma requisição do tipo `GET` para a rota `[url de sua aplicação]/api/products/[id do produto]`

#### Listar produtos
**Observação: lembre de adicionar o access_token ao cabeçalho da requisição (Authorization Bearer [access_token])**

Basta realizar uma requisição do tipo `GET` para a rota `[url de sua aplicação]/api/products`

###Fim

------------

Desenvolvido por Marcony Caldeira utilizando o Laravel e a lib tymondesigns/jwt-auth