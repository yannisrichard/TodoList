# TodoList
2016 PHP Project : TodoList symfony 3

##Create BDD : Docker image mysql
$ docker run -d \
    --volume /var/lib/mysql \
    --name data_mysql \
    --entrypoint /bin/echo \
    busybox \
    "mysql data-only container"


$ docker run -d -p 3306 \
    --name mysql \
    --volumes-from data_mysql \
    -e MYSQL_USER=uframework \
    -e MYSQL_PASS=p4ssw0rd \
    -e ON_CREATE_DB=uframework \
    tutum/mysql


$ mysql uframework -h127.0.0.1 -P<assigned port> -uuframework -p  
<assigned port> = $ docker ps

$docker stop mysql # or its ID

$docker start mysql # or its ID


Creer Entity avec Doctrine : $ php bin/console doctrine:generate:entity

Generer getters/setters : $ php bin/console doctrine:generate:entities TodoListBundle/Entity/Product

Creer/Mettre à jour la base de données : $ php bin/console doctrine:schema:update --force

Generer Form : $ php app/console generate:doctrine:form TodoListBundle:Task

Lancer un script sql dans docker :
$ php bin/console doctrine:database:drop --force
$ php bin/console doctrine:database:create
$ docker exec -i 552d5f6352b7 mysql -uuframework -pp4ssw0rd < schema.sql

Commande Sql :
SHOW DATABASES;
use uframework;
show tables;



Lancer app : php bin/console server:run

# ROUTES :
http://127.0.0.1:8000/tasklist/createTaskTest  
http://127.0.0.1:8000/  
http://127.0.0.1:8000/tasklist  
http://127.0.0.1:8000/tasklist/new  
http://127.0.0.1:8000/tasklist/show/1  
http://127.0.0.1:8000/tasklist/update/1  
http://127.0.0.1:8000/tasklist/delete/1  
     
http://127.0.0.1:8000/task/1  
http://127.0.0.1:8000/task/update/1  
http://127.0.0.1:8000/task/delete/1  


HELP : 
- yaml problème indentation, solution réécrire.
- doctrine : http://symfony.com/doc/current/book/doctrine.html

