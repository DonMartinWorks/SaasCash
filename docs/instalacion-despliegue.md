# CashTackr

TODO: Explicación del proyecto.

[← Volver al README Principal](../README.md)

---

## 1. Configuración de Variables de Entorno

Al clonar el proyecto, crea una copia del archivo de configuración inicial:

```bash
cp .env.example .env
```

Asegúrate de ajustar dentro del archivo .env las credenciales de la base de datos para que coincidan con las de tu servicio en docker-compose.yml (por ejemplo, DB_HOST=db o DB_HOST=mysql).

## 2. Despliegue y Comandos de Inicialización

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

> `Otorgar permisos de escritura`: Evitar errores 500 y solucionar que las imágenes se guarden como '0' (false)

```bash
docker compose exec app chmod -R 777 storage bootstrap/cache
```