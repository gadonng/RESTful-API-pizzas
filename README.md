PIZZAS API REST
================

Quickstart
-------------

You need to have [docker](http://www.docker.com) (>=1.5.0) and
[docker-compose](https://docs.docker.com/compose/install/) installed.

then use:
```sh
docker-compose up
```

Now you have a built an image with Apache, a yii 2.0 app and MySQL running,
you can access the server with:

http://<Your-github-ip>:8080

if you want to change the port head to docker-compose.yml
and change :
```sh
ports:
        - "8080:80"
```
to whatever you need.

You can see/create/modify/delete ingredients and pizzas by calling these routes:

	192.168.99.100/<Object> verb: GET (gets all Object)
	192.168.99.100/<Object> verb: POST (create a new Object)
	192.168.99.100/<Object>/<id> verb: GET (gets an Object with a specific <id>)
	192.168.99.100/<Object>/<id> verb: PUT (Modify an existing Object with a specific <id>)

You can replace <Object> by either ingredients or pizzas

ex: 192.168.99.100/ingredients verb: POST (gets all ingredients)
	192.168.99.100/pizzas/42 verb: PUT (modify the pizza with the id 42)

docker-compose run --rm web ./yii migrate/up --interactive=0