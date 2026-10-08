# CashTackr

TODO: Explicación del proyecto.

[← Volver al README Principal](../README.md)

---

## Archivo `Makefile`

> El proyecto incluye un `Makefile` para automatizar la puesta en marcha del entorno de desarrollo local con Docker y Laravel.

**OJO:** _Esta sección es para automatizar la instalación. Si utilizas este método, puedes omitir la ejecución manual `(docs/arquitectura-servicios.md)`._

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
 @echo "Configuración completada con éxito"

stop:
 @echo "Deteniendo contenedores..."
 docker compose down

clean:
 @echo "Eliminando contenedores, volúmenes e imágenes de este proyecto..."
 docker compose down -v --rmi local

permission:
 @echo "Asignando propiedad y permisos al código fuente..."
 sudo chown -R $$USER:$$USER src/
 docker compose exec app chown -R www-data:www-data storage bootstrap/cache
 docker compose exec app chmod -R 775 storage bootstrap/cache

refresh-db:
 @echo "Haciendo las migraciones y seeders..."
 docker compose exec app php artisan migrate:fresh --seed
 @echo "Configuración completada con éxito"

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

### Uso `permission`

Para refrescar los permisos de escritura y propiedad de la carpeta `src/` y las carpetas `storage` y `bootstrap/cache` dentro del contenedor:

```bash
make permission
```

### Uso `refresh-db`

Para refrescar la base de datos y ejecutar las migraciones y seeders:

```bash
make refresh-db
```

### Uso `destroy` (⚠️ Precaución)

Para eliminar todo el sistema Docker local (imágenes, volúmenes y caché de Docker de la máquina, incluyendo otros proyectos):

```bash
make destroy
```

#### > 💡 **Nota sobre la primera ejecución (Entorno limpio):**

> Si borraste las imágenes/contenedores previamente o es la primera vez que levantas el proyecto, Docker tardará unos minutos en descargar e inicializar las imágenes. Si las migraciones fallan por tiempo de espera de la base de datos en el primer intento, simplemente vuelve a ejecutar `make setup`.

---
