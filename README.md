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

