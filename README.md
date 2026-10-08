# CashTackr

TODO: Explicación del proyecto.

---

## 👥 Usuarios por Defecto

Listado de los usuarios **POR DEFECTO** `@laravel.com` es el nombre de la app: **APP_NAME=Laravel**

### Panel Inicio de sesión (`/login`) (**Datos por defecto**)

| Campo          | Nombre            | Nombre            | Nombre                | Nombre               |
| :------------- | :---------------- | :---------------- | :-------------------- | :------------------- |
| **Nombre**     | Usuario Uno       | Usuario Dos       | Usuario Tres          | Usuario Cuatro       |
| **Email**      | `uno@laravel.com` | `dos@laravel.com` | `tercero@laravel.com` | `Cuatro@laravel.com` |
| **Contraseña** | `1234`            | `1234`            | `1234`                | `1234`               |

## 📚 Documentación y Guías

- 🌐 [Arquitectura de Servicios y Visores de Base de Datos](docs/arquitectura-servicios.md)
- 🌐 [Despliegue y Comandos de Inicialización](docs/instalacion-despliegue.md)
- ⚙️ [Configuración de Variables de Entorno (`.env`)](docs/archivo-env.md)
- 🛠️ [Instalación y Despliegue con Docker / Makefile](docs/makefile.md)
- 🐧 [Desarrollo y Solución de Problemas en WSL2](docs/guia-wsl.md)
- 🧪 [Suite de Pruebas con Pest PHP](docs/testing.md)
- 🧹 [Mantenimiento y Limpieza](docs/mantenimiento-limpieza.md)
- 📚 [Otros Comandos](docs/otros-comandos.md)

## Resumen makefile

### Uso `setup`

Para ejecutar todo el proceso de inicialización en un solo paso, ejecuta en la raíz del proyecto:

```bash
make setup
```

### Uso `stop`

Para detener los contenedores sin eliminar tus datos ni imágenes, ejecuta:

```bash
make stop
```

## 📄 Resumen: Configuración para `src/.env` de Laravel

> Copia el bloque correspondiente al motor de base de datos que vayas a utilizar dentro del archivo c (`archivo .env`) de tu proyecto Laravel (`src/.env`):

```.env
DB_CONNECTION=pgsql
DB_HOST=db_postgres
DB_PORT=5432
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=Secret_Password123!
```

## Contacto

Mi Cuenta GitHub: [https://github.com/DonMartinWorks](https://github.com/DonMartinWorks)

## ☻☻☻ Gracias por escoger este proyecto ☻☻☻
