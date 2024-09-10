# Construa e Execute
1. Clone o Repositório
```
git clone https://github.com/isaquemenezes/laravel-api-usuario.git
cd api  && cd frontend-vuejs
```
2. Instalar Dependências
```
composer install

```

3. Configure seu Banco favorito(aqui estamos com Postgres):
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
``` 
4. Rode as Migrates e Levante o servidor :
 ```
 php artisan migrate && php artisan serve
``` 

5. Front end vue js
```
npm run serve
```


4. Testar a Aplicação | navegador| Postman| Ferramenta como o curl:
```
curl http://127.0.0.1:8000/api/users
```

### Tecnologias

- **[via Cep](https://viacep.com.br/)**
- [Postman](https://www.postman.com/)
- [Visual Studio Code](https://code.visualstudio.com/)
- [Git](https://git-scm.com/)
- [GiHub](https://github.com/)
- [PHP | 8.1.27 ](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Bootstrap 5.3](https://getbootstrap.com/)
- [Vue: 3.2 ](https://vuejs.org/)
- [DBeaver ](https://dbeaver.io/download/)
- [PostgreSQL](https://www.postgresql.org/)

## API Doc
- GET /api/users — Listar todos os usuários.
- POST /api/users — Criar um novo usuário
- GET /api/users/{id} — Exibir detalhes de um usuário.
- PUT/PATCH /api/users/{id} — Atualizar um usuário existente.
- DELETE /api/users/{id} — Deletar um usuário.
