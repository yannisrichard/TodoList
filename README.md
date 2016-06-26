# TodoList
2016 PHP Project : TodoList symfony 3

##Create BDD  
### 1 - Docker image mysql  
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

### 2 - Creer/Mettre à jour la base de données    
$ php bin/console doctrine:schema:update --force 

##Lancer l'application    
$ php bin/console server:run

##Commandes utiles
Se connecter à la base de données docker :      
$ mysql uframework -h10.0.75.2 -P32768 -uuframework -p 
10.0.75.2 et 32768 sont données par la commande $ docker ps   
Commande Sql :
SHOW DATABASES;
use uframework;
show tables;

Démarrer/Stopper Mysql :
$docker stop mysql # or its ID
$docker start mysql # or its ID

Creer Entity avec Doctrine :     
$ php bin/console doctrine:generate:entity  
Generer getters/setters :   
$ php bin/console doctrine:generate:entities TodoListBundle/Entity/Product   
Creer/Mettre à jour la base de données :  
$ php bin/console doctrine:schema:update --force  
Generer Form :   
$ php bin/console generate:doctrine:form TodoListBundle:Task 

##Bug : 
- Après Oauth.
cURL error 60: SSL certificate problem: unable to get local issuer certificate (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)

