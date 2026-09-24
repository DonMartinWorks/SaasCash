# Real Estate Platform (SaasCash Clone)

Esta es una aplicación web de bienes raíces desarrollada con **PHP Laravel**, diseñada para publicar, buscar y gestionar propiedades inmobiliarias (venta y alquiler), conectar agentes con clientes y explorar inmuebles de forma interactiva.

---

## 👥 Usuarios por Defecto

Listado de los usuarios **POR DEFECTO** `@laravel.com` es el nombre de la app: **APP_NAME=Laravel**

### Panel Inicio de sesión (`/login`) (**Datos por defecto**)

| Campo          | Nombre               | Nombre                | Nombre                |
| :------------- | :------------------- | :-------------------- | :-------------------- |
| **Nombre**     | Usuario Normal       | Usuario Segundo       | Usuario Tercero       |
| **Email**      | `normal@laravel.com` | `segundo@laravel.com` | `tercero@laravel.com` |
| **Contraseña** | `1234`               | `1234`                | `1234`                |

## ⚙️ Variables de Entorno (`.env` Raíz)

### `.env` (en la ruta base)

```.env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:3000
APP_PORT=3000
VITE_PORT=5173
APP_DOMAIN=localhost

# TAGS DE IMÁGENES POR SERVICIO
WEB_IMAGE_TAG=alpha-1
APP_IMAGE_TAG=alpha-1
NODE_IMAGE_TAG=alpha-1
WORKER_IMAGE_TAG=alpha-1
SCHEDULER_IMAGE_TAG=alpha-1
DB_IMAGE_TAG=alpha-1
VITE_IMAGE_TAG=alpha-1

CONTAINER_PREFIX=app_laravel
CONTAINER_APP_NAME=${CONTAINER_PREFIX}_php
CONTAINER_WEB_NAME=${CONTAINER_PREFIX}_web
CONTAINER_NODE_NAME=${CONTAINER_PREFIX}_node
CONTAINER_DB_NAME=${CONTAINER_PREFIX}_db
CONTAINER_DB_MANAGER_NAME=${CONTAINER_PREFIX}_db_manager
CONTAINER_MAIL_NAME=${CONTAINER_PREFIX}_mail
CONTAINER_QUEUE_NAME=${CONTAINER_PREFIX}_queue

PHP_VERSION=8.5.10-fpm-alpine3.24
NGINX_VERSION=1.31.6-alpine3.24
NODE_VERSION=24-alpine3.23
PGADMIN_VERSION=9.17
MAILPIT_VERSION=v1.31.0
POSTGRES_VERSION=14.24-alpine3.23

MAILPIT_UI_PORT=8025
MAILPIT_SMTP_PORT=1025
DB_MANAGER_PORT=8080

# CONFIGURACIÓN DE BASE DE DATOS (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=db_postgres
DB_PORT=5432
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=Secret_Password123!
DB_USER_PASSWORD=admin@db.com
DB_ROOT_PASSWORD=root_password
DB_PORT_FORWARD=5432

# CONFIGURACIÓN DE CACHÉ, SESIÓN Y COLAS
CACHE_STORE=redis
SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=redis

# CONFIGURACIÓN DE REDIS
REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# CONFIGURACIÓN DE MAILPIT / LARAVEL
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@localhost"
MAIL_FROM_NAME="${APP_NAME}"

# ALMACENAMIENTO Y VITE
FILESYSTEM_DISK=local
VITE_APP_NAME="${APP_NAME}"
```

### `.env` (del proyecto Laravel)

```.env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:3000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=es_ES

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

# PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=db_postgres
DB_PORT=5432
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=Secret_Password123!

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local

QUEUE_CONNECTION=redis
CACHE_STORE=file
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Servicio de correo (Mailpit)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@localhost"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"


```

### 📄 Archivo: Configuración para `src/.env` de Laravel

> Copia el bloque correspondiente al motor de base de datos que vayas a utilizar dentro del archivo c de tu proyecto Laravel (`src/.env`):

#### `PostgreSQL`

```.env
DB_CONNECTION=pgsql
DB_HOST=db_postgres
DB_PORT=5432
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=Secret_Password123!
```

### 1. Configuración de Variables de Entorno

Al clonar el proyecto, crea una copia del archivo de configuración inicial:

```bash
cp .env.example .env
```

Asegúrate de ajustar dentro del archivo .env las credenciales de la base de datos para que coincidan con las de tu servicio en docker-compose.yml (por ejemplo, DB_HOST=db o DB_HOST=mysql).

### 2. Despliegue y Comandos de Inicialización

Ejecuta los siguientes comandos en orden cronológico

```bash
# Levantar los contenedores en segundo plano
  docker compose up -d --build

  # Otorgar permisos de escritura para evitar errores 500
  docker compose exec app chmod -R 777 storage bootstrap/cache

  # Instalar las dependencias de Composer dentro del contenedor
  docker compose exec app composer install

  # Instalar las dependencias de Node.js
  docker compose exec app npm install

  # Compilar los archivos estáticos de Node.js
  docker compose exec app npm run build

  # Generar la llave de la aplicación (App Key)
  docker compose exec app php artisan key:generate

  # Ejecutar las migraciones de la base de datos
  docker compose exec app php artisan migrate

  # Poblar la base de datos con los seeders iniciales
  docker compose exec app php artisan db:seed

  # Crear el enlace simbólico para el almacenamiento de archivos
  docker compose exec app php artisan storage:link
```

```bash
  # Eliminar el enlace simbólico para el almacenamiento de archivos
  docker compose exec app php artisan storage:unlink
```

## 🐧 Desarrollo Ultra-Rápido con WSL2 (Windows 11 / 10 + Ubuntu)

> Si desarrollas desde **Windows**, se recomienda ejecutar este proyecto dentro del sistema de archivos nativo de **Linux (WSL2)** en lugar del sistema de archivos de Windows (`C:\...`).

## ⚡ ¿Por qué mover el proyecto a WSL2?

- **Recarga instantánea con Vite (HMR):** Al guardar archivos `.vue` o `.jsx`, los cambios se reflejan en **menos de 100ms** (en `C:\` puede tardar varios segundos por el cuello de botella I/O entre NTFS y Linux).
- **Cero consumo excesivo de CPU:** Permite desactivar `usePolling: true` en Vite.
- **Compatibilidad nativa:** Evita fallos de lectura/escritura en `node_modules` y carpetas de caché.

### Tip en Solución de Problemas (WSL2 / Git line endings)

> 💡 **Tip:** Si algún script de bash (`.sh`) falla al ejecutarse dentro de un contenedor en WSL2, asegúrate de guardar el archivo con saltos de línea estilo Linux (**LF**) en lugar de Windows (**CRLF**).

## 📂 1. Ubicación Correcta del Proyecto

El proyecto **DEBE** estar clonado/guardado dentro del directorio de usuario de Ubuntu:

| Entorno                  | Ruta del Proyecto                                                | Rendimiento          |
| :----------------------- | :--------------------------------------------------------------- | :------------------- |
| ❌ **Incorrecto (NTFS)** | `/mnt/c/Apps-Laravel/SaasCash` (o `C:\Apps-Laravel\SaasCash`)    | Muy Lento            |
| **Correcto (Linux)**     | `~/proyectos/SaasCash` (o `/home/tu_usuario/proyectos/SaasCash`) | **Velocidad Nativa** |

### ¿Cómo copiar el proyecto a la ruta nativa de Linux?

Desde tu terminal de **Ubuntu (WSL)**:

```bash
# Crear directorio de proyectos
mkdir -p ~/proyectos

# Copiar el proyecto excluyendo carpetas pesadas/temporales
rsync -av --exclude='src/storage' --exclude='src/vendor' --exclude='src/node_modules' --exclude='.git' /mnt/c/RutaDeTuProyecto/ ~/proyectos/SaasCash/

# Entrar al proyecto
cd ~/proyectos/SaasCash
```

### 💻 2. Trabajo en VS Code desde WSL2

1. Abre tu terminal de `Ubuntu`

2. Navega al proyecto y abre VS Code:

```bash
cd ~/proyectos/SaasCash
code .
```

3. VS Code abrirá conectado de forma nativa a `Ubuntu` (verás la etiqueta azul/verde `WSL: Ubuntu` en la esquina inferior izquierda)

**💡 Tip para el Explorador de Archivos de Windows:**

_Si quieres ver o manipular las carpetas desde Windows, presiona `Win + R` y escribe_ **`\\wsl$\Ubuntu\home\tu_usuario\proyectos\SaasCash`**

### 🛠️ 3. Solución de Problemas Comunes en WSL2

Error de Permisos en Laravel (`Permission denied` en `laravel.log` o `storage`)
Si Docker o PHP no pueden escribir en la carpeta `storage` al mover el proyecto, otorga permisos globales a las carpetas temporales desde Ubuntu

```bash
  cd ~/proyectos/SaasCash/src
  chmod -R 777 storage bootstrap/cache
```

> (`Opcional`: Si quieres solucionarlo directamente dentro del contenedor de PHP/Laravel):

```bash
  # Otorgar permisos de escritura para evitar errores 500 y solucionar que las imágenes se guarden como '0' (false)
  docker compose exec app chmod -R 777 storage bootstrap/cache
```

#### Bloqueos de permisos al editar (Windows/Ubuntu - Docker)

> 💡 **Nota:** Si creas controladores o migraciones mediante comandos de Docker, los archivos pertenecerán al usuario `root`. Si VS Code te da un error de permisos (`EPERM`) al intentar guardarlos, restablece la propiedad a tu usuario de Linux:

```cmd
  # Si estás en la terminal de Windows (PowerShell/CMD), accede primero a WSL:
  wsl
```

```bash
  # Cambiar la propiedad de los archivos generados por Docker a tu usuario de Linux (evita bloqueos de permisos al editar) (Te preguntará por tu cuenta de linux (user y password))
  sudo chown -R $USER:$USER src/
```

### Error de Git: `dubious ownership in repository`

Ocurre al intentar ejecutar comandos de git desde PowerShell o la consola de Windows en una carpeta de Linux

- Solución recomendada: Ejecuta los comandos de Git siempre desde la terminal integrada de VS Code (WSL) o la terminal de Ubuntu
- Solución para Windows: Si prefieres usar PowerShell, ejecuta este comando una sola vez en PowerShell para marcar el directorio como seguro

```cmd
  git config --global --add safe.directory '*'
```

### 🗑️ Cómo Eliminar el Proyecto en Ubuntu (WSL)

Si necesitas eliminar este proyecto de tu entorno de Ubuntu en WSL, sigue estos pasos en orden para asegurarte de limpiar tanto la infraestructura de Docker (contenedores, redes y bases de datos) como los archivos en el disco.

#### Paso 1: Apagar y eliminar la infraestructura Docker

Abre tu terminal de **Ubuntu** y entra a la carpeta del proyecto

```cmd
  cd ~/proyectos/SaasCash
```

> Ejecuta el siguiente comando para detener los contenedores y borrar los volúmenes de datos (base de datos de PostgreSQL, caché, etc.)

- ⚠️ Nota: El **flag** -v elimina los datos almacenados en la base de datos de Docker. Si deseas conservar la base de datos y solo eliminar los archivos del código, omite el -v.

```bash
  docker compose down -v
```

#### Paso 2: Eliminar la carpeta del proyecto

_Sal de la carpeta del proyecto e ingresa a tu directorio raíz de proyectos:_

```bash
cd ~/proyectos
```

**Elimina la carpeta del proyecto por completo con el comando `rm -rf`**

```bash
rm -rf SaasCash
```

> 🛑 Atención: El comando `rm -rf` elimina la carpeta permanentemente y sin pasar por la papelera de reciclaje de Windows. Asegúrate de haber guardado tus cambios o subido tu código a un repositorio de Git antes de ejecutarlo.

##### 💡 Alternativa: Eliminar desde el Explorador de Archivos de Windows

Si prefieres eliminar los archivos mediante la interfaz gráfica de Windows después de haber ejecutado `docker compose down -v`:

1. Presiona `Win + R`.
2. Escribe la ruta de red de tu usuario en WSL: **`\\wsl$\Ubuntu\home\tu_usuario\proyectos`**
3. Haz clic derecho sobre la carpeta del proyecto (**SaasCash**) y selecciona `Eliminar`

## Otros Comandos

1. Limpiar todo el historial de los comandos de linux con WSL.

```cmd
  history -c && rm ~/.bash_history && exit
```

```cmd
  history -c
```

## Contacto

Mi Cuenta GitHub: [https://github.com/DonMartinWorks](https://github.com/DonMartinWorks)

## ☻☻☻ Gracias por escoger este proyecto ☻☻☻</h4>

## 🌐 Arquitectura de Servicios y Visores de Base de Datos

| Servicio                       | URL Local / Puerto      | Conexión y Credenciales                                                                    |
| :----------------------------- | :---------------------- | :----------------------------------------------------------------------------------------- |
| **Laravel App**                | `http://localhost:3000` | Servidor Web Nginx + PHP 8.4-FPM                                                           |
| **Vite / Node**                | `http://localhost:5173` | Servidor de desarrollo Frontend HMR                                                        |
| **Node CLI**                   | `(Sin Puerto)`          | Ejecución de comandos NPM `(docker compose exec node ...)`                                 |
| **pgAdmin 4 (PostgreSQL)**     | `http://localhost:8080` | Usuario: `admin@db.com` \| Clave: `root_password`                                          |
| **Clientes GUI de Escritorio** | `localhost:5432`        | Acceso directo a DB desde DBeaver / TablePlus (Host: `localhost`, Usuario: `laravel_user`) |
| **Mailpit UI**                 | `http://localhost:8025` | Interfaz Web para interceptar correos de prueba locales                                    |
| **Redis DB**                   | `localhost:6379`        | Gestor de mensajes para colas `(Host interno: redis)`                                      |
| **Queue Worker**               | `(Segundo Plano)`       | Procesador de trabajos asíncronos `(docker compose logs -f worker)`                        |
| **Scheduler (Cron)**           | `(Segundo Plano)`       | Automatiza tareas programadas como `storage:clean-orphans`                                 |

### pgAdmin

#### PASO 1: Iniciar Sesión en pgAdmin

1. Entra desde tu navegador a: `http://localhost:8080` (o el puerto configurado en `DB_MANAGER_PORT`).
2. Usa las credenciales definidas en tu `.env`:

| Valor    | Credencial por defecto `.env`         |
| :------- | :------------------------------------ |
| Email    | `DB_USER_PASSWORD`: **admin@db.com**  |
| Password | `DB_ROOT_PASSWORD`: **root_password** |

#### PASO 2: Registrar y Conectar el Servidor de `PostgreSQL`

**Al entrar verás el panel principal (Dashboard). Necesitas decirle a pgAdmin a qué servidor conectarse dentro de Docker:**

1. Haz clic en `Add New Server` (o clic derecho en Servers en la barra lateral izquierda ➔ Register ➔ Server...).

2. En la pestaña General: **`Name`: Escribe un nombre descriptivo, por ejemplo: `Laravel Postgres`**

3. Ve a la pestaña Connection e ingresa los datos de tu contenedor PostgreSQL:

| Campo                | Valor que debes colocar   | ¿Por qué?                                                                                                                                       |
| :------------------- | :------------------------ | :---------------------------------------------------------------------------------------------------------------------------------------------- |
| Host name/address    | `db_postgres`             | Es el nombre del servicio en tu `docker-compose.yml`. No uses `localhost`, los contenedores se leen por nombre de servicio en la red de Docker. |
| Port                 | `5432`                    | Puerto interno del contenedor.                                                                                                                  |
| Maintenance database | `postgres (o laravel_db)` | Base de datos por defecto para probar la primera conexión.                                                                                      |
| Username             | `laravel_user`            | Valor de `${DB_USERNAME}` de tu `.env`.                                                                                                         |
| Password             | `Secret_Password123!`     | Valor de `${DB_PASSWORD}` de tu `.env`.                                                                                                         |
| Save password?       | `Marca la casilla`        | `OPCIONAL`: Para evitar que te pida la clave cada vez que entres a pgAdmin.                                                                     |

4. Haz clic en `Save`.

#### PASO 3: Crear la Base de Datos

**En el momento en que guardes la conexión, Docker usará la imagen de PostgreSQL para inicializar automáticamente la base de datos `laravel_db` definida en tu `.env` (`POSTGRES_DB`: `${DB_DATABASE}`).**

_Si necesitas crear la base de datos manualmente o crear otra adicional:_

1. En la columna izquierda, despliega el servidor que acabas de guardar (`Laravel Postgres`).
2. Haz clic derecho en `Databases` ➔ `Create` ➔ `Database`...
3. En el campo Database, escribe: `laravel_db` (o el nombre que prefieras).
4. En Owner, selecciona `laravel_user`.
5. Haz clic en `Save`.

#### PASO 4: Ejecutar las Migraciones en Laravel

**Con la base de datos creada y la conexión establecida en pgAdmin, solo queda correr las migraciones de Laravel desde la terminal dentro del contenedor PHP:**

```cmd
  docker compose exec app php artisan migrate
```

_Si todo está bien, verás la creación de las tablas predeterminadas de Laravel (`users`, `migrations`, `sessions`, etc.) y al refrescar el árbol en pgAdmin (dentro de `laravel_db` ➔ `Schemas` ➔ `public` ➔ `Tables`), podrás ver todas tus tablas creadas._

---

## ⚡ Instalación Inicial Paso a Paso

### 1. Sincronizar entorno `.env`

Copia la configuración de la raíz a la carpeta de Laravel:

- Windows: `Copy-Item .env src/.env`

- Linux / macOS: `cp .env src/.env`

> 💡 **Nota sobre el archivo `.env`:** El `.env` de la raíz contiene tanto variables de infraestructura (Docker) como de Laravel. Al copiarlo directamente a `src/.env`, Laravel ignorará las variables propias de Docker (como `CONTAINER_PREFIX` o `PHP_VERSION`). Esto **no afecta el funcionamiento ni genera errores**, pero si prefieres un archivo más limpio dentro de la app, puedes borrar esas variables de `src/.env` y conservar solo la sección del proyecto Laravel.

### 2. Levantar la infraestructura

- Para desarrollar con PostgreSQL:

```cmd
  docker compose up -d
```

### 3. Ajustes de permisos y clave

#### Alias recomendado

```cmd
  # Crear un alias temporal en la terminal para no escribir tanto:
  alias art="docker compose exec app php artisan"

  # Ejemplo de uso:
  art migrate
  art make:controller TestController
```

> 💡 Puedes usar el alias para abreviar los comandos

```bash
# Generar App Key
docker compose exec app php artisan key:generate

# Correr migraciones iniciales
docker compose exec app php artisan migrate
```

```bash
# En caso de tener registros corruptos guardados como '0', limpiar la BD
docker compose exec app php artisan migrate:fresh
```

```bash
# Limpiar el storage de las imágenes huérfanas (Sin listado asignado):
docker compose exec app php artisan storage:clean-orphans
```

> `Otorgar permisos de escritura`: Evitar errores 500 y solucionar que las imágenes se guarden como '0' (false)

```bash
docker compose exec app chmod -R 777 storage bootstrap/cache
```

## 🛠️ Comandos de Uso Frecuente

_Códigos genéricos que podrían ser útiles._

- Artisan

```bash
  docker compose exec app php artisan migrate
  docker compose exec app php artisan migrate:fresh --seed
  docker compose exec app php artisan make:model Post -mcr
```

- Composer

```bash
  docker compose exec app composer require laravel/breeze
```

- NPM / Frontend

```bash
  docker compose exec node npm install
  docker compose exec node npm install -D tailwindcss
  docker compose exec node npm run build
  docker compose exec node npm run fix:eslint
```

- Reiniciar Vite

```bash
  docker compose restart vite
```

### Optimización de Autoload (Composer)

> Reconstruye el mapa de clases de Composer dentro del contenedor sin ejecutar `php`
> explícitamente como argumento.

```bash
docker compose exec app composer dump-autoload
```

#### ¿Para qué sirve este comando?

- **Actualizar el mapa de clases (Class Map):** Si agregas manualmente nuevas clases,
  interfaces, _traits_, o creas archivos dentro de `app/`, `database/seeders/` o
  `database/factories/` que no son detectados automáticamente por el _autoloader_ PSR-4.

- **Resolver errores de clase no encontrada (`Class not found`):** Fuerza a Composer a
  reesccanear todo el árbol del proyecto en `src/` para registrar cualquier archivo
  recién creado.
- **Optimización en Producción (`--optimize` / `-o`):** Convierte las reglas PSR-0/
  PSR-4 en un mapa plano (_classmap_) de alto rendimiento para acelerar la carga de la
  aplicación.

#### Ejemplos de uso según el entorno

```bash
# Regeneración estándar del autoloader (Desarrollo)
docker compose exec app composer dump-autoload

# Modo optimizado (Rendimiento superior / Pruebas)
docker compose exec app composer dump-autoload -o
```

### Comandos útiles según el tipo de reinicio que necesites

- Reinicio rápido de todos los contenedores:

```bash
  docker compose restart
```

- Reinicio forzado (destruye los contenedores y los vuelve a levantar):

```bash
  docker compose down && docker compose up -d
```

- Reinicio aplicando cambios en el `docker-compose.yml` o **eliminando huérfanos**

```bash
  docker compose up -d --force-recreate --remove-orphans
```

- Reiniciar un solo servicio (por ejemplo, `vite` o `app`)

```bash
  docker compose restart vite
```

### IDE Helper Generator

> Ejecuta esto para añadir phpdocs a tus modelos

```bash
  docker compose exec app php artisan ide-helper:models -RW
```

## 🧹 Mantenimiento y Limpieza

> ⚠️ **Nota:** Ejecuta estos comandos desde la carpeta raíz del proyecto (donde reside el archivo `docker-compose.yml`, no en **src**). ⚠️

1. Ejecutándolos desde la carpeta del proyecto (La forma recomendada)

- **Detener los contenedores (sin borrar datos):**

```bash
  docker compose stop
```

- Detener y eliminar contenedores/redes (Conserva datos de la BD):

```bash
  docker compose down
```

- Borrar todo incluyendo la Base de Datos (Reset de Volúmenes):

```bash
  docker compose down -v
```

- Reset Nuclear (Borrado profundo de todo el motor Docker): **⚠️ ¡Cuidado especial con el "Reset Nuclear"!**

```bash
  docker compose down -v --rmi all
  docker system prune -a --volumes -f
```

2. Si estás fuera de la carpeta o quieres ser 100% específico

_Si no estás ubicado dentro de la carpeta del proyecto o quieres asegurarte desde cualquier lugar de la consola de no tocar otra cosa, puedes pasar el flag `-p` **(nombre del proyecto)** o `-f` **(ruta del archivo)**:_

- Usando el nombre del proyecto:

```bash
  docker compose -p mi_app_laravel down -v
```

- Apuntando al archivo docker-compose.yml específico:

```bash
  docker compose -f /ruta/a/tu/proyecto/docker-compose.yml down -v
```

## 🧪 Testing con Pest & Docker

Este proyecto utiliza [Pest PHP](https://pestphp.com/) como framework de pruebas. Debido a que el entorno de PHP se ejecuta dentro del contenedor de Docker, todos los comandos de Pest, Artisan y Composer deben ejecutarse mediante `docker compose exec`.

### 📐 Organización de la Suite de Pruebas

| Archivo de Test            | Responsabilidad Principal                              | Cobertura de Casos                                                                                                  |
| :------------------------- | :----------------------------------------------------- | :------------------------------------------------------------------------------------------------------------------ |
| **`LoginUserTest.php`**    | Flujos de inicio y cierre de sesión.                   | Formulario de login, autenticación exitosa, opción "Recordarme", logout y credenciales inválidas.                   |
| **`RegisterUserTest.php`** | Alta de usuario y flujo de verificación.               | Formulario de registro, validación de campos, alta de usuario no verificado, eventos, correos y enlace firmado.     |
| **`DashboardTest.php`**    | Protección de rutas y control de acceso (Middlewares). | Bloqueo a invitados (`guest`), redirección de usuarios no verificados y acceso a usuarios autenticados/verificados. |

---

### 1. Instalación e Inicialización

Si estás configurando las pruebas por primera vez o reinstalando Pest, sigue estos pasos:

#### **Paso 1: Instalar Pest y el Plugin de Laravel**

Ejecuta Composer dentro del contenedor `app` para añadir Pest y sus dependencias de desarrollo:

```bash
docker compose exec app composer require pestphp/pest pestphp/pest-plugin-laravel --dev --with-all-dependencies
```

> **Nota:** No elimines `phpunit/phpunit` manualmente, ya que Pest lo utiliza internamente como dependencia.

#### **Paso 2: Inicializar la Configuración de Pest**

Genera la configuración inicial y el archivo de pruebas `Pest.php`:

```bash
docker compose exec app ./vendor/bin/pest --init
```

---

### 2. Creación de Pruebas (Generación de Tests)

Puedes crear distintos tipos de pruebas utilizando los comandos de Artisan dentro del contenedor:

#### **Pruebas de Funcionalidad (Feature Tests)**

Se usan para probar la interacción entre múltiples componentes (rutas, controladores, base de datos, peticiones HTTP, respuestas, etc.).

```bash
docker compose exec app php artisan make:test UserRegistrationTest --pest
```

#### **Pruebas Unitarias (Unit Tests)**

Se usan para probar clases, helpers o algoritmos de forma aislada, sin interactuar con la base de datos o el framework completo.

```bash
docker compose exec app php artisan make:test MathHelperTest --unit --pest
```

#### **Pruebas de Arquitectura (Arch Tests)**

Se usan para enforcing de reglas de arquitectura (por ejemplo, asegurar que los controladores no llamen directamente a modelos o que no se usen funciones como `dd()` en producción).

```bash
docker compose exec app php artisan make:test ArchitectureTest --pest
```

---

### 3. Ejecución de Pruebas

#### **Ejecutar toda la suite de pruebas**

```bash
docker compose exec app ./vendor/bin/pest
```

> ⚠️ Tambien se pueden ejecutar las pruebas de esta manera.

```bash
docker compose exec app php artisan test
```

#### **Ejecutar un archivo específico**

```bash
docker compose exec app ./vendor/bin/pest tests/Unit/ExampleTest.php
```

#### **Filtrar pruebas por nombre**

```bash
docker compose exec app ./vendor/bin/pest --filter "nombre del test"
```

#### **Ejecutar pruebas en paralelo (opcional)**

Si deseas ejecutar tus tests de forma paralela para reducir el tiempo de ejecución:

```bash
docker compose exec app ./vendor/bin/pest --parallel
```

---

## Archivo `Makefile`

> El proyecto incluye un `Makefile` para automatizar la puesta en marcha del entorno de desarrollo local con Docker y Laravel.

**OJO:** _Esta sección es para automatizar la instalación. Si utilizas este método, puedes omitir la ejecución manual de los pasos 2 y 3._ **(De la sección siguiente)**

### Prerrequisitos

- Docker / Docker Desktop
- **RECOMENDACIÓN:** `sudo apt update` para actualizar su sistema Linux antes de instalar `make`.
- `make` instalado en tu sistema (`sudo apt install make` en Ubuntu / WSL2).

### Estructura del `Makefile`

```makefile
setup:
	@echo "1. Levantando contenedores..."
	docker compose up -d
	@echo "2. Esperando a que la base de datos y los servicios inicien... (40 segundos de espera)"
	sleep 40
	@echo "3. Ejecutando migraciones y seeders..."
	docker compose exec app php artisan migrate:fresh --seed
	@echo "4. Asignando propiedad local al código fuente..."
	sudo chown -R $$USER:$$USER src/
	@echo "5. Asignando permisos a storage y bootstrap/cache dentro del contenedor..."
	docker compose exec app chown -R www-data:www-data storage bootstrap/cache
	docker compose exec app chmod -R 775 storage bootstrap/cache
	@echo "6. Limpiando caché de vistas compiladas..."
	docker compose exec app php artisan view:clear
	docker compose restart vite
	@echo "Configuración completada con éxito"

stop:
	@echo "Deteniendo contenedores..."
	docker compose down

clean:
	@echo "Eliminando contenedores, volúmenes e imágenes de este proyecto..."
	docker compose down -v --rmi local

destroy:
	@echo "¡ADVERTENCIA! Eliminando absolutamente todo el sistema Docker local..."
	docker compose down -v --rmi all
	docker system prune -a --volumes -f
	docker builder prune -a -fsetup:
	@echo "1. Levantando contenedores..."
	docker compose up -d
	@echo "2. Esperando a que la base de datos y los servicios inicien... (40 segundos de espera)"
	sleep 40
	@echo "3. Ejecutando migraciones y seeders..."
	docker compose exec app php artisan migrate:fresh --seed
	@echo "4. Asignando propiedad local al código fuente..."
	sudo chown -R $$USER:$$USER src/
	@echo "5. Asignando permisos a storage y bootstrap/cache dentro del contenedor..."
	docker compose exec app chown -R www-data:www-data storage bootstrap/cache
	docker compose exec app chmod -R 775 storage bootstrap/cache
	@echo "6. Limpiando caché de vistas compiladas..."
	docker compose exec app php artisan view:clear
	docker compose restart vite
	@echo "Configuración completada con éxito"

stop:
	@echo "Deteniendo contenedores..."
	docker compose down

clean:
	@echo "Eliminando contenedores, volúmenes e imágenes de este proyecto..."
	docker compose down -v --rmi local

destroy:
	@echo "¡ADVERTENCIA! Eliminando absolutamente todo el sistema Docker local..."
	docker compose down -v --rmi all
	docker system prune -a --volumes -f
	docker builder prune -a -f
```

### Uso `setup`

Para ejecutar todo el proceso de inicialización en un solo paso, ejecuta en la raíz del proyecto:

```bash
make setup
```

⚠️ Nota importante sobre sudo en `make setup`:

> El script utiliza `sudo` para devolver la propiedad de la carpeta `src/` a tu usuario local de Linux/WSL2 (evitando errores de permisos al editar código desde VS Code). Durante la ejecución de `make setup`, la terminal te pedirá la contraseña de tu usuario de Linux/WSL2. Simplemente ingrésala para permitir que finalice la configuración.

### Uso `stop`

Para detener los contenedores sin eliminar tus datos ni imágenes, ejecuta:

```bash
make stop
```

### Uso `clean`

Para detener y borrar los contenedores, volúmenes e imágenes generadas exclusivamente por este proyecto:

```bash
make clean
```

### Uso `destroy` (⚠️ Precaución)

Para eliminar todo el sistema Docker local (imágenes, volúmenes y caché de Docker de la máquina, incluyendo otros proyectos):

```bash
make destroy
```

#### > 💡 **Nota sobre la primera ejecución (Entorno limpio):**

> Si borraste las imágenes/contenedores previamente o es la primera vez que levantas el proyecto, Docker tardará unos minutos en descargar e inicializar las imágenes. Si las migraciones fallan por tiempo de espera de la base de datos en el primer intento, simplemente vuelve a ejecutar `make setup`.

# Real Estate Platform (SaasCash Clone)

Esta es una aplicación web de bienes raíces desarrollada con **PHP Laravel**, diseñada para publicar, buscar y gestionar propiedades inmobiliarias (venta y alquiler), conectar agentes con clientes y explorar inmuebles de forma interactiva.

---

## ⚡ Instalación Inicial Paso a Paso

### 1. Sincronizar entorno `.env`

Copia la configuración de la raíz a la carpeta de Laravel:

- Windows: `Copy-Item .env src/.env`

- Linux / macOS: `cp .env src/.env`

> 💡 **Nota sobre el archivo `.env`:** El `.env` de la raíz contiene tanto variables de infraestructura (Docker) como de Laravel. Al copiarlo directamente a `src/.env`, Laravel ignorará las variables propias de Docker (como `CONTAINER_PREFIX` o `PHP_VERSION`). Esto **no afecta el funcionamiento ni genera errores**, pero si prefieres un archivo más limpio dentro de la app, puedes borrar esas variables de `src/.env` y conservar solo la sección del proyecto Laravel.

### 2. Levantar la infraestructura

- Para desarrollar con PostgreSQL:

```cmd
  docker compose up -d
```

### 3. Ajustes de permisos y clave

#### Alias recomendado

```cmd
  # Crear un alias temporal en la terminal para no escribir tanto:
  alias art="docker compose exec app php artisan"

  # Ejemplo de uso:
  art migrate
  art make:controller TestController
```

> 💡 Puedes usar el alias para abreviar los comandos

```bash
# Generar App Key
docker compose exec app php artisan key:generate

# Correr migraciones iniciales
docker compose exec app php artisan migrate
```

```bash
# En caso de tener registros corruptos guardados como '0', limpiar la BD
docker compose exec app php artisan migrate:fresh
```

```bash
# Limpiar el storage de las imágenes huérfanas (Sin listado asignado):
docker compose exec app php artisan storage:clean-orphans
```

> `Otorgar permisos de escritura`: Evitar errores 500 y solucionar que las imágenes se guarden como '0' (false)

```bash
docker compose exec app chmod -R 777 storage bootstrap/cache
```

## 🛠️ Comandos de Uso Frecuente

_Códigos genéricos que podrían ser útiles._

- Artisan

```bash
  docker compose exec app php artisan migrate
  docker compose exec app php artisan migrate:fresh --seed
  docker compose exec app php artisan make:model Post -mcr
```

- Composer

```bash
  docker compose exec app composer require laravel/breeze
```

- NPM / Frontend

```bash
  docker compose exec node npm install
  docker compose exec node npm install -D tailwindcss
  docker compose exec node npm run build
  docker compose exec node npm run fix:eslint
```

- Reiniciar Vite

```bash
  docker compose restart vite
```

### Optimización de Autoload (Composer)

> Reconstruye el mapa de clases de Composer dentro del contenedor sin ejecutar `php`
> explícitamente como argumento.

```bash
docker compose exec app composer dump-autoload
```

#### ¿Para qué sirve este comando?

- **Actualizar el mapa de clases (Class Map):** Si agregas manualmente nuevas clases,
  interfaces, _traits_, o creas archivos dentro de `app/`, `database/seeders/` o
  `database/factories/` que no son detectados automáticamente por el _autoloader_ PSR-4.

- **Resolver errores de clase no encontrada (`Class not found`):** Fuerza a Composer a
  reesccanear todo el árbol del proyecto en `src/` para registrar cualquier archivo
  recién creado.
- **Optimización en Producción (`--optimize` / `-o`):** Convierte las reglas PSR-0/
  PSR-4 en un mapa plano (_classmap_) de alto rendimiento para acelerar la carga de la
  aplicación.

#### Ejemplos de uso según el entorno

```bash
# Regeneración estándar del autoloader (Desarrollo)
docker compose exec app composer dump-autoload

# Modo optimizado (Rendimiento superior / Pruebas)
docker compose exec app composer dump-autoload -o
```

### Comandos útiles según el tipo de reinicio que necesites

- Reinicio rápido de todos los contenedores:

```bash
  docker compose restart
```

- Reinicio forzado (destruye los contenedores y los vuelve a levantar):

```bash
  docker compose down && docker compose up -d
```

- Reinicio aplicando cambios en el `docker-compose.yml` o **eliminando huérfanos**

```bash
  docker compose up -d --force-recreate --remove-orphans
```

- Reiniciar un solo servicio (por ejemplo, `vite` o `app`)

```bash
  docker compose restart vite
```

### IDE Helper Generator

> Ejecuta esto para añadir phpdocs a tus modelos

```bash
  docker compose exec app php artisan ide-helper:models -RW
```

## 🧹 Almacenamiento Automático y Limpieza de Imágenes Huérfanas

Para evitar el desperdicio de espacio en disco y la acumulación de archivos sin uso, el sistema incluye un proceso automático en segundo plano que escanea el almacenamiento físico (`storage/app/public/images`) y elimina de forma permanente cualquier archivo que ya no tenga un registro asociado en la base de datos de PostgreSQL.

### Comando Personalizado de Artisan

La lógica de limpieza está empaquetada dentro de un comando de consola dedicado: `CleanOrphanImages`

```php
<?php

namespace App\Console\Commands;

use App\Models\ListingImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
class CleanOrphanImages extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'storage:clean-orphans';

    /**
     * The console command description.
     */
    protected $description = 'Remove orphan image files from disk that are no longer associated with the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $disk = Storage::disk('public');

        // Retrieve all physical files inside the 'images' directory
        $allFiles = $disk->allFiles('images');

        // Map filenames stored in the database
        $dbFiles = ListingImage::pluck('filename')->flip();

        $deletedCount = 0;

        foreach ($allFiles as $file) {
            // If the physical file is not registered in the database, delete it
            if (!$dbFiles->has($file)) {
                $disk->delete($file);
                $deletedCount++;
            }
        }

        $this->info("Cleanup completed: {$deletedCount} orphan images were removed.");
    }
}
```

## Ejecutar la Limpieza de Imágenes Huérfanas de Forma Manual

```bash
  docker compose exec app php artisan storage:clean-orphans
```

### Registro en la Programación de Tareas

El comando se configura para ejecutarse automáticamente en `routes/console.php:`

```php
use Illuminate\Support\Facades\Schedule;

# Ejecuta la tarea de limpieza de imágenes huérfanas cada 30 minutos.

Schedule::command('storage:clean-orphans')->everyThirtyMinutes();
```

### 3. Ejecución en Segundo Plano mediante Docker

_El contenedor `scheduler` ejecuta `php artisan schedule:work` de manera continua en segundo plano. Analiza periódicamente el calendario de Laravel y ejecuta `storage:clean-orphans` automáticamente sin requerir la configuración de un cronjob en el sistema operativo anfitrión._

🛠 Comandos Habituales de Desarrollo

> Como no se requiere software local (PHP, Composer, Node) instalado en la máquina anfitriona, todas las operaciones se ejecutan a través de los contenedores de Docker:

- Reinicia los contenedores para aplicar la nueva configuración de volúmenes:

```bash
  docker compose up -d --force-recreate
```

- Inspeccionar la Lista de Tareas Programadas:

```bash
  docker compose exec app php artisan schedule:list
```

- Monitorear los Logs del Worker y Scheduler en Tiempo Real:

```bash
  docker compose logs -f worker scheduler
```

## Posibles Errores

1. Error: SQLSTATE[42P01]: Undefined table: 7 ERROR: relation "sessions" does not exist LINE 1: select _ from "sessions" where "id" = $1 limit 1 ^ (Connection: pgsql, Host: db_postgres, Port: 5432, Database: laravel_db, SQL: select _ from "sessions" where "id" = data limit 1)

```cmd
  docker compose exec app php artisan migrate:fresh --seed
```
