# Cashier + Stripe

TODO: Explicación del proyecto.

[← Volver al README Principal](../README.md)

---

## 🛠 Configuración del Sistema de Pagos (Stripe)

Este proyecto utiliza un sistema de configuración dinámico que prioriza los valores almacenados en la Base de Datos sobre los del archivo `.env`.

- Obtención de Credenciales en Stripe
- Inicia sesión en el <a href="https://dashboard.stripe.com/test/dashboard" target="_blank">Stripe Dashboard</a>.

Ve a la sección Desarrolladores y luego a API Keys.

- Asegúrate de estar en el modo Test (para pruebas) o desactívalo para Live (producción).

- Copia la `Publishable key` (Clave pública) y la `Secret key` (Clave secreta).

### 📄 Archivo: Configuración para `src/.env` de Laravel

> Copia el bloque correspondiente al motor de base de datos que vayas a utilizar dentro del archivo c (`archivo .env`) de tu proyecto Laravel (`src/.env`):

```.env
STRIPE_KEY=pk_test_blahblah
STRIPE_SECRET=sk_test_blahblah
STRIPE_WEBHOOK_SECRET=whsec_blahblah

CASHIER_CURRENCY=clp
CASHIER_CURRENCY_LOCALE=es_MX
STRIPE_PRICE_VIEW_MONTHLY=5000
STRIPE_PRICE_VIEW_YEARLY=48000
STRIPE_PRICE_AI_MONTHLY=price_ID_precio_blahblah
STRIPE_PRICE_AI_YEARLY=price_ID_precio_blahblah
```

---
> `STRIPE_PRICE_VIEW_MONTHLY`, `STRIPE_PRICE_AI_MONTHLY`: **Los valores deben coincidir entre estos dos para que las suscripciones mensuales funcionen correctamente**
---

---
> `STRIPE_PRICE_VIEW_YEARLY`, `STRIPE_PRICE_AI_YEARLY`: **Los valores deben coincidir entre estos dos para que las suscripciones anuales funcionen correctamente**
---

`Stripe Key`: Clave pública de la API de Stripe utilizada en el cliente. #Clave publicable

`Stripe Secret`: Clave secreta de la API de Stripe para procesar pagos y peticiones seguras en el servidor.

`Stripe Webhook Secret`: Token secreto para verificar y recibir notificaciones seguras de los eventos de Stripe.

`Stripe Price at View Monthly`: Identificador del plan mensual configurado en Stripe para la suscripción de visualización.

`Stripe Price at View Yearly`: Identificador del plan anual configurado en Stripe para la suscripción de visualización.

`Cashier Currency`: Moneda predeterminada para las transacciones de Laravel Cashier.

`Cashier Currency Locale`: Configuración regional (locale) empleada para dar formato a los precios y monedas.

`Stripe Price at AI Monthly` Identificador del precio o plan mensual configurado en Stripe para la suscripción de IA.

`Stripe Price at AI Yearly` Identificador del precio o plan anual configurado en Stripe para la suscripción de IA.

`Stripe Webhook URL` URL del webhook de Stripe para recibir notificaciones de eventos.

---

## 🛍 Catálogo de Productos y Planes

_Para que las suscripciones y cobros funcionen correctamente en la aplicación, es necesario tener dados de alta los productos y sus respectivos precios recurrentes dentro de Stripe._

### I- Creación de Productos en el Panel

> Importante: Antes de configurar las variables en el archivo `.env`, asegúrate de crear los productos y precios (mensual y anual) en el panel de Stripe. **(Nota: Para el plan anual, multiplica el precio mensual por 10 para ofrecer 2 meses gratis)**.

- `https://dashboard.stripe.com/acct_ID/test/products?source=product_list&create=product` <- La url para crear productos en Stripe. **ID es del producto**

1. Ingresa a la sección de Productos (Products) en el Stripe Dashboard.

2. Haz clic en Añadir producto (Add product).

3. Configura los detalles generales:

    - Nombre: Por ejemplo, Suscripción Plan IA.

    - Descripción: Breve detalle de lo que incluye el plan.

### II- Configuración de Precios Recurrentes

Para cada producto, define los esquemas de precios que utilizará Laravel Cashier (`STRIPE_PRICE_AI_MONTHLY` y `STRIPE_PRICE_AI_YEARLY`):

- Modelo de precios: Estándar.

- Precio: Define el monto y la moneda (ej. $10 USD o $100 USD).

- Esquema de facturación: Recurrente (Recurring).

- Período de cobro:

Para el plan mensual: Selecciona Mensual (Monthly).

Para el plan anual: Selecciona Anual (Yearly).

Una vez creados, copia los identificadores de precio (que comienzan con `price_...`) y asegúrate de asignarlos a sus respectivas variables en el archivo `.env`.

### 🔍 Cómo Obtener las Credenciales en el Panel de Stripe

1. Inicia sesión en el Stripe Dashboard.

2. Claves de API (`STRIPE_KEY` y `STRIPE_SECRET`):

    - Dirígete a la sección Desarrolladores (Developers) y luego a API Keys.

    - Asegúrate de alternar entre el modo Test o Live según necesites.

    - Copia la `Publishable key` (Clave pública) para `STRIPE_KEY` y haz clic en Reveal test key para copiar la `Secret key` (Clave secreta) en `STRIPE_SECRET`.

3. Secreto del Webhook (`STRIPE_WEBHOOK_SECRET`):

    - En el menú de Desarrolladores, ve a `Webhooks`.

    - Añade un punto de conexión (endpoint) apuntando a tu ruta de webhook (por ejemplo, `https://tudominio.com/stripe/webhook`).

    - Una vez creado, haz clic en el webhook y revela la clave secreta de firma (`Signing secret`) para copiarla aquí.

4. Precios y Planes (`STRIPE_PRICE_AI_MONTHLY` y `STRIPE_PRICE_AI_YEARLY`):

    - Ve a la sección Productos (Products) en el panel principal.

    - Crea o selecciona tu producto de suscripción y desplázate a la sección de Precios (Prices).

    - Copia el identificador único del precio (suele comenzar con `price_...`) correspondiente tanto al plan mensual como al anual.

> Si aplicas el comando `docker compose exec stripe-cli stripe listen --forward-to localhost:3000/stripe/webhook` en tu terminal, podrás recibir eventos de Stripe en tiempo real y verificar que la configuración del webhook funciona correctamente, copiando el `STRIPE_WEBHOOK_SECRET` generado en el panel de Stripe.

La nueva configuración del container de Stripe CLI se encuentra en el archivo `.env` de la raíz del proyecto, con la variable `STRIPE_CLI_IMAGE_TAG=v1.23.0`.

## Pasos para usar el servicio de Stripe CLI en el proyecto

1. Asegúrate de tener el contenedor de Stripe CLI corriendo en tu entorno de desarrollo.
2. Si te pide login, ejecuta `docker compose exec stripe-cli stripe login` y sigue las instrucciones para autenticarte.

    ```cmd
    docker compose exec stripe-cli stripe login
    ```

3. Una vez autenticado, puedes iniciar el listener de eventos de Stripe con el siguiente comando: **localhost:3000 debe coincidir con la URL de tu aplicación Laravel**

    ```cmd
    docker compose exec stripe-cli stripe listen --forward-to localhost:3000/stripe/webhook
    ```

4. Cuando se genere un evento en Stripe (por ejemplo, una suscripción creada o un pago exitoso), el listener capturará ese evento y lo reenviará a tu aplicación Laravel en la ruta especificada (`/stripe/webhook`).
5. Para verificar que todo funciona correctamente, puedes revisar los logs del contenedor de tu aplicación Laravel para ver si los eventos están siendo recibidos y procesados adecuadamente.
6. Recuerda que para que los eventos de Stripe sean procesados correctamente, debes tener configurado el controlador de webhook en tu aplicación Laravel y asegurarte de que la ruta `/stripe/webhook` esté correctamente definida y protegida según las mejores prácticas de seguridad.
7. Si necesitas detener el listener, puedes hacerlo con `Ctrl + C` en la terminal donde se está ejecutando el comando de escucha.
8. Para más detalles sobre cómo manejar los eventos de Stripe en Laravel, consulta la documentación oficial de Laravel Cashier y Stripe Webhooks.
9. Asegúrate de mantener tus claves de API y secretos seguros y no los compartas públicamente.
10. Si estás trabajando en un entorno de producción, asegúrate de cambiar las claves de API a las correspondientes del modo Live y de configurar correctamente los webhooks para recibir eventos en tu aplicación en producción.
11. Copia y pega los identificadores de precios (`STRIPE_PRICE_AI_MONTHLY` y `STRIPE_PRICE_AI_YEARLY`) en tu archivo `.env (app laravel)` para que Laravel Cashier pueda utilizarlos al crear suscripciones.
12. Verifica que los productos y precios estén correctamente configurados en el panel de Stripe antes de realizar pruebas de suscripción en tu aplicación.

_Para copiar el `STRIPE_WEBHOOK_SECRET`, puedes encontrarlo en el container **(click en el nombre del servicio)** de docker con una line similar a la siguiente:_

**whsec_hash** es el valor que debes copiar y pegar en tu archivo `.env` para la variable `STRIPE_WEBHOOK_SECRET`. **_hash** es un valor único generado por Stripe para tu webhook específico. Es único para tu aplicación.

```bash
Your webhook signing secret is whsec_hash (^C to quit)
```
