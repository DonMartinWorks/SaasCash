# CashTackr

TODO: Explicación del proyecto.

[← Volver al README Principal](../README.md)

---

## 🧪 Testing con Pest & Docker

Este proyecto utiliza [Pest PHP](https://pestphp.com/) como framework de pruebas. Debido a que el entorno de PHP se ejecuta dentro del contenedor de Docker, todos los comandos de Pest, Artisan y Composer deben ejecutarse mediante `docker compose exec`.

### 📐 Organización de la Suite de Pruebas

| Archivo de Test                    | Responsabilidad Principal                                                        | Cobertura de Casos                                                                                                                                                                                                                                                                                                                                  |
| :--------------------------------- | :------------------------------------------------------------------------------- | :-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **`LoginUserTest.php`**            | Flujos de inicio y cierre de sesión.                                             | Formulario de login, autenticación exitosa, opción "Recordarme", logout y credenciales inválidas.                                                                                                                                                                                                                                                   |
| **`RegisterUserTest.php`**         | Alta de usuario y flujo de verificación.                                         | Formulario de registro, validación de campos, alta de usuario no verificado, eventos, correos y enlace firmado.                                                                                                                                                                                                                                     |
| **`DashboardTest.php`**            | Protección de rutas y control de acceso (Middlewares).                           | Bloqueo a invitados (`guest`), redirección de usuarios no verificados y acceso a usuarios autenticados/verificados.                                                                                                                                                                                                                                 |
| **`Budgets/DashboardTest.php`**    | Vista principal de presupuestos y aislamiento de datos por usuario.              | Muestra de estado vacío cuando no existen registros, renderizado correcto del listado de presupuestos y filtrado estricto/aislamiento de datos para mostrar solo los presupuestos del usuario autenticado.                                                                                                                                          |
| **`Budgets/CreateBudgetTest.php`** | Creación de presupuestos, reglas de validación y control de acceso.              | Validación de campos obligatorios (nombre, monto, tipo), restricción a usuarios invitados (`guest`) y no verificados, asignación del presupuesto al usuario autenticado, validación de monto positivo (>0), restricción de tipos de presupuesto válidos y redirección con mensaje de éxito.                                                         |
| **`Budgets/EditBudgetTest.php`**   | Formulario y acceso a la edición de presupuestos.                                | Acceso permitido al propietario con visualización de datos, restricción/redirección a invitados (`guest`) y denegación de acceso (HTTP 403 / Forbidden) a usuarios no propietarios.                                                                                                                                                                 |
| **`Budgets/UpdateBudgetTest.php`** | Actualización de presupuestos, reglas de validación y políticas de autorización. | Edición exitosa por el propietario con verificación en BD y mensaje flash, validación de campos obligatorios (`name`, `amount`, `type`), validación de `monto mayor a cero (>0)`, restricción de tipos válidos, protección contra actualizaciones por invitados (`guest`) y bloqueo a otros usuarios manteniendo la integridad en la base de datos. |
| **`Budgets/DeleteBudgetTest.php`** | Eliminación de presupuestos y control de acceso (Middlewares/Policies).          | Eliminación lógica (soft delete) exitosa por el propietario con redirección y mensaje de éxito, bloqueo y redirección a login para invitados (`guest`), redirección a aviso de verificación para usuarios no verificados y denegación de acceso (HTTP 403 / Forbidden) a otros usuarios preservando el registro en la BD.                           |

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
