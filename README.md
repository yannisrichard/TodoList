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

$docker stop mysql # or its ID

$docker start mysql # or its ID

<assigned port> = $ docker ps

Creer Entity avec Doctrine : $ php bin/console doctrine:generate:entity

Generer getters/setters : $ php bin/console doctrine:generate:entities TodoListBundle/Entity/Product

Creer la base de données : $ php bin/console doctrine:schema:update --force

Lancer un script sql dans docker :
$ php bin/console doctrine:database:drop --force
$ php bin/console doctrine:database:create
$ docker exec -i 552d5f6352b7 mysql -uuframework -pp4ssw0rd < schema.sql

Commande Sql :
SHOW DATABASES;
use uframework;
show tables;


Lancer app : php bin/console server:run

NOTE : 
Si yaml problème indentation, solution réécrire.
