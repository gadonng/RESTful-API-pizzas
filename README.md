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

Now you have a built image with an Apache, a yii 2.0 app and a 5.6 MySQL running,
you can access the server with:

http://<Your-docker-ip>:8080

before using the api you should do a migration (after docker-compose up):
```sh
docker-compose run --rm web ./yii migrate/up --interactive=0
```

you can use all the yii commands this way,
if you can't use the interactive version of docker-compose run you should add the --interactive=0 to yii commands.
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

	<Your-docker-ip>:8080/api/<objects> verb: GET (gets all Object)
	<Your-docker-ip>:8080/api/<objects> verb: POST (create a new Object)
	<Your-docker-ip>:8080/api/<objects>/<id> verb: GET (gets an Object with a specific <id>)
	<Your-docker-ip>:8080/api/<objects>/<id> verb: PUT (Modify an existing Object with a specific <id>)

	ex: 
	192.168.99.100/api/v1/ingredients verb: POST (gets all ingredients)
	192.168.99.100/api/v1/pizzas/42 verb: PUT (modify the pizza with the id 42)

for a POST or PATCH you can send the name of attributes directly:

{
	"name":"tomato"
}

There is other routes, you should check the yii 2.0 documentation to see the basics routes taking care of.
You can replace "object" by either ingredients or pizzas and you can replace "version" by the version you want to use, currently v1 

You can access relationships either by a expand=pizza on ingredient view route or expand=ingredient on pizza view route

or use those routes to manipulate relationships:

	GET <Your-docker-ip>:8080/api/<Objects>/<id>/relationships/<Object> view relationships
	POST <Your-docker-ip>:8080/api/<Objects>/<id>/relationships/<Object> create relationships
	PATCH <Your-docker-ip>:8080/api/<Objects>/<id>/relationships/<Object> update relationships
	DELETE <Your-docker-ip>:8080/api/<Objects>/<id>/relationships/<Object> delete relationships

	example of routes: http://192.168.99.100:8080/api/ingredients/1/relationships/pizza

	for POST and PATCH you should organize data this way to add or modify relationships, here we are creating new relationships for an ingredient of id 1:

	POST http://192.168.99.100:8080/api/ingredients/1/relationships/pizza

	{
    "data":[
        {"type":"pizzas", "id":2, "quantity":30},
        {"type":"pizzas", "id":3, "quantity":50}
        ]
	}

	quantity is here to notify how much of one ingredient do we have to put on the pizza


Possible upgrades
------------------

There is still room for improvements:

- add a modular structure so we have multiple folders in root like: frontend/ backend/ and api/ for the rest api where we can also manage versionning, see http://www.yiiframework.com/doc-2.0/guide-rest-versioning.html

- making a docker image for BDD so we don't use the basic 5.6 mysql image but an image with migrations and population already done, with versionning so we easily can retrieve an old state.
	(need hosting image, and change the load of 5.6mysql in docker-compose.yml)

- could implement a User access control

- implement all of the vnd.api+json convention

- creating frontend and backend on our needs