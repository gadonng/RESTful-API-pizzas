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

Now you have a built image with an Apache, a yii 2.0 app and a MySQL running,
you can access the server with:

http://<Your-github-ip>:8080

before using the api you should do a migration (after docker-compose up):
```sh
docker-compose run --rm web ./yii migrate/up --interactive=0
```

you can use all the yii commands this way
```sh
docker-compose run --rm web ./yii <command>
```

if you want to change the port, head to docker-compose.yml
and change :
```sh
ports:
        - "8080:80"
```
to whatever you need.

You can see/create/modify/delete ingredients and pizzas by calling these routes:

	192.168.99.100/api/<version>/<object> verb: POST (create a new Object)
	192.168.99.100/api/<version>/<object>/<id> verb: GET (gets an Object with a specific <id>)
	192.168.99.100/api/<version>/<object>/<id> verb: PUT (Modify an existing Object with a specific <id>)

You can replace "object" by either ingredients or pizzas and you can replace "version" by the version you want to use, currently v1 

ex: 192.168.99.100/api/v1/ingredients verb: POST (gets all ingredients)
	192.168.99.100/api/v1/pizzas/42 verb: PUT (modify the pizza with the id 42)


Possible upgrades
------------------

- add a modular structure so we have multiple folders in root like: frontend/ backend/ and api/ for the rest api where we can also manage versionning

- adding filters options so we can search pizzas with kinds of ingredients

- making a docker image for BDD so we don't use the basic 5.6 mysql image but an image with migrations and population already done, with versionning so we easily can retrieve an old state.

