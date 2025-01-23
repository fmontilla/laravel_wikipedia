Laravel Wikipedia

Projeto desenvolvido em Laravel que realiza crawler no wikipedia.

Instalação e Execução

- Clone o repositório

Configuração do ambiente:

- Certifique-se de ter o Docker instalado.
- Execute `docker-compose up -d`

Acesse o container do PHP:

- `docker exec -it laravel_wikipedia-laravel.test-1 bash`
  
Crie a base de dados:

- Execute o comando `php artisan migrate` dentro do container

Rode o comando para capturar os dados das empresas:

- Execute o comando `php artisan companies:capture` dentro do container

Execução de testes:

- Execute o comando `vendor/bin/phpunit` dentro do container
  
Teste a API:

Você pode testar a API usando ferramentas como Postman ou curl. Exemplo de requisição:
http

POST http://localhost/api/filter-companies
Content-Type: application/json
{
    "rule": "greater",
    "billions": 15
}

