# Laravel0 <br />
**Fecha de Creacion:** _17 de Agosto del 2023_ <br />
**Descripción:** proyecto que tiene la finalidad de servir de base para otros.<br />
**Version del laravel:** _9.52.15_ <br />
**Version del PHP:** _PHP 8.1.13 (cli) (built: Nov 22 2022 15:49:14)_ <br />

## Base de Datos ## <br />
**Tabla:** _users_ <br />
**Estructura de la tabla users** <br />
<img src="./sql/users.png" alt="Tabla User" title="Tabla User">

### Paso 1. Crear un nuevo proyecto a partir de este ### <br />
git clone https://github.com/techjesusparra/laravel0.git nuevo_proyecto <br />

## Configuraciones ## <br />
### Paso 2. Creacion de una base de datos y su configuracion ### <br />
Crear una base de dato e insertar un usuario administrador de la aplicacion
Es script lo encontrar en el directorio **SQL** dentro del proyecto con el nombre de **laravel0-DB.sql**, puede opcionalmente modificar los datos antes de realizar el insert.

DB_CONNECTION=_mysql_ <br />
DB_HOST=_<Servidor de la base de datos>_ <br />
DB_PORT=_3306_ <br />
DB_DATABASE=_<Nombre de la base de datos>_ <br />
DB_USERNAME=_<Usuario de la base de datos>_ <br />
DB_PASSWORD=_<Contraseña>_ <br />

### Paso 2. Prueba del ORM del Modelo Usuario ### <br />
