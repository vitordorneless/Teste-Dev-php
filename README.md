# **Teste para Desenvolvedor: API de Cadastro de Clientes com Validação de CEP**

# Teste Vítor Dorneles Pimentel

Teste realizado para ser candidato a vaga de Desenvolvedor.

Segue o caminho para deixar a aplicação em funcionamento.

Para o funcionamento do Docker:

$docker-compose up -d

Para começar o MySQL:

$docker-compose start

Para o Laravel:

$php artisan migrate

$php artisan db:seed

## Documentação da API

#### Retorna todos os itens

```http
  GET /api/clients
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `filter` | `string` | para pesquisar CPF, email ou CEP |

#### Retorna um item

```http
  GET /api/clients/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. O ID do item que você quer |

#### Edita um cliente

```http
  PUT /api/clients/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. O ID do item que você DESEJA atualizar |

#### Excluir um cliente

```http
  DELETE /api/clients/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. O ID do item que você DESEJA excluir |


Muito Obrigado.