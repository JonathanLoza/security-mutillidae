# Engenharia de Segurança Segundo Trabalho

**Membros**

- Jonathan Loza
- Ian Arias Schreiber
- Alan Evangelista
- Brian Chuquiruna


## Executar mutillidae com as correções de vulnerabilidades

- Execute o <code>docker-compose up</code> do arquivo muttillidae-docker/docker-compose.yml
- Criar novo certificado no contêiner mutillidae/www:latest e ativar o mod\_rewrite:
```
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/mutillidae-selfsigned.key -out /etc/ssl/certs/mutillidae-selfsigned.crt

a2enmod rewrite

service apache2 restart
```
- Redefinir banco de dados no localhost
- Criar tabela no banco de dados localhost:81 em schema mutillidae:
```sql
create table logins(
 id varchar(255) unique,
 tries smallint,
 time datetime
);
```


