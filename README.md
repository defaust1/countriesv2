Proyecto de Gestión de Países v1
-----------------------------------------------------------------
Este proyecto es una aplicación web desarrollada con el framework Symfony que permite gestionar una lista de países. Incluye funcionalidades como añadir países desde una API externa, buscar, editar, eliminar y realizar una gestión activa/inactiva de los países.

-----------------------------------------------------------------

Características
---------------
----------------------------------------------------------------------------------------
Añadir países desde una API externa: Importa datos actualizados desde REST Countries API.
------------------
Gestión de países:
------------------
- Listar todos los países en una tabla paginada.
- Buscar países de manera dinámica mientras se escribe.
- Editar información de un país.
- Eliminar un país de la base de datos.
- Añadir Paises

Gestión de estados activos/inactivos:
Los países inactivos no se actualizan ni sobrescriben al añadir nuevos datos desde la API.

----------------------
Requisitos del Sistema
----------------------

- PHP 8.1 o superior.
- Symfony 6.
- Composer.
- MySQL o cualquier base de datos compatible con Doctrine.
- Node.js y npm (opcional, si se utiliza Webpack Encore).
- Bootstrap 5 para el diseño.

-----------------------
Instalación
-----------------------
Clona el repositorio:


Copiar código:

git clone <url-del-repositorio>
cd <nombre-del-proyecto>
-------------------------
Instala las dependencias:
-------------------------

copiar código:
composer install

Configura las variables de entorno: Copia el archivo .env y edítalo para configurar tu base de datos:

copiar código:
cp .env .env.local
Modifica la variable DATABASE_URL con las credenciales de tu base de datos.

Crea la base de datos y ejecuta las migraciones:
-------------------------------------------------
Copiar código:

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
Carga datos iniciales: Si deseas importar países por primera vez desde la API:

Copiar código:
php bin/console app:update-countries

-------------------------------------
Inicia el servidor de desarrollo:
-------------------------------------

symfony serve
Accede a la aplicación: Abre en tu navegador: http://localhost:8000.


