# ASONAP API
Sistema automatizado de gestion de certificados .

## Requerimientos tecnicos 
* PHP 8.2.7
* MariaDB 10.4
* PhpMyAdmin
* Composer Version 2.5.

## Modo Desarrollo docker

Primero debemos preparar el entorno de docker para que tenga los recursos e imagenes necesarias de contenedor.

`docker compose pull`
Esto descarga las imagenes necesarias para el funcionamiento del micro servicio

`docker compose build`
Esto compila los servicios necesarios para correr el codigo fuente.

`docker compose up -d`
Para levantar los servicios de desarrollo.

Haciendo esto inmediatamente se levantan 3 servicios necesarios para el funcionamiento del api estos son **MariaDB** **PhpMyAdmin** **Slim**

Los servicios estan interconectados desde el codigo fuente y no es necesario hacer nada mas para que funcione correctamente desde docker en modo desarrollo.

