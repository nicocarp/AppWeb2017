Para correr la aplicacion con  docker-compose

sudo chmod 777 -R web

docker-compose up

ingresar en http://0.0.0.0:8888/phpmyadmin/ 

Crear la base de datos con el nombre carro_db

ejecutar en terminal docker exec -ti <nombre_contenedor> bash

	/opt/lampp/bin/php artisan migrate

Con esto la base de datos carro_db debe quedar lista para usar. 

http://0.0.0.0:8888/www/carro/public/	

Reiniciar el servidor:

docker exec carro_laravel  /opt/lampp/lampp restart

