# CashTackr

TODO: Explicación del proyecto.

[← Volver al README Principal](../README.md)

---

## 📚 Otros Comandos de Uso Frecuente

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

### Alias recomendado

```cmd
  # Crear un alias temporal en la terminal para no escribir tanto:
  alias art="docker compose exec app php artisan"

  # Ejemplo de uso:
  art migrate
  art make:controller TestController
```

## Posibles Errores y otros comandos

1. Error: SQLSTATE[42P01]: Undefined table: 7 ERROR: relation "sessions" does not exist LINE 1: select _from "sessions" where "id" = $1 limit 1 ^ (Connection: pgsql, Host: db_postgres, Port: 5432, Database: laravel_db, SQL: select_ from "sessions" where "id" = data limit 1)

```cmd
  docker compose exec app php artisan migrate:fresh --seed
```

---

### _Limpiar toda la cache de la app_

```cmd
  docker compose exec app php artisan o:c
```

### _Crear o reiniciar la cache de rutas_

```cmd
  docker compose exec app php artisan route:cache
```

### _Generar o reiniciar archivos de tipos para Ziggy_

```cmd
  docker compose exec app php artisan ziggy:generate --types
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

## Limpieza

1. Limpiar todo el historial de los comandos de linux con WSL.

```cmd
  history -c && rm ~/.bash_history && exit
```

```cmd
  history -c
```
