# CashTackr

TODO: Explicación del proyecto.

[← Volver al README Principal](../README.md)

---

## 🌐 Arquitectura de Servicios y Visores de Base de Datos

| Servicio                       | URL Local / Puerto      | Conexión y Credenciales                                                                    |
| :----------------------------- | :---------------------- | :----------------------------------------------------------------------------------------- |
| **Laravel App**                | `http://localhost:3000` | Servidor Web Nginx + PHP 8.4-FPM                                                           |
| **Vite / Node**                | `http://localhost:5173` | Servidor de desarrollo Frontend HMR                                                        |
| **Node CLI**                   | `(Sin Puerto)`          | Ejecución de comandos NPM `(docker compose exec node ...)`                                 |
| **pgAdmin 4 (PostgreSQL)**     | `http://localhost:8080` | Usuario: `admin@db.com` \| Clave: `root_password`                                          |
| **Clientes GUI de Escritorio** | `localhost:5432`        | Acceso directo a DB desde DBeaver / TablePlus (Host: `localhost`, Usuario: `laravel_user`) |
| **Mailpit UI**                 | `http://localhost:8025` | Interfaz Web para interceptar correos de prueba locales                                    |

### pgAdmin

#### PASO 1: Iniciar Sesión en pgAdmin

1. Entra desde tu navegador a: `http://localhost:8080` (o el puerto configurado en `DB_MANAGER_PORT`).
2. Usa las credenciales definidas en tu `.env`:

| Valor    | Credencial por defecto `.env`          |
| :------- | :------------------------------------- |
| Email    | `DB_USER_PASSWORD`: **<admin@db.com>** |
| Password | `DB_ROOT_PASSWORD`: **root_password**  |

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

1. Haz clic en `Save`.

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
