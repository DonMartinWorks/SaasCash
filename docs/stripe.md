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

### Makefile: Configuración Automática del Webhook

**make setup** ya va a ejecutar el comando de escucha del webhook automáticamente al final de la configuración, por lo que no es necesario ejecutarlo manualmente.