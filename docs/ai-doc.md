# OpenRouter/React AI Documentación

## 🔑 Configuración de Cuenta y Obtención de API Keys en OpenRouter

### 1. Crear una Cuenta en OpenRouter

1. Ve al sitio web oficial: [openrouter.ai](https://openrouter.ai/).
2. Haz clic en el botón **Sign In** (o **Sign Up**) ubicado en la esquina superior derecha.
3. Puedes registrarte e iniciar sesión utilizando tu cuenta de **Google**, **GitHub** o tu correo electrónico.

---

### 2. Configurar Créditos (Saldo)

Para poder consumir la API (incluso con modelos de bajo costo), necesitas recargar un saldo inicial:

1. Dirígete a la sección de **Credits** en la barra lateral o mediante el menú de tu perfil (`https://openrouter.ai/credits`).
2. Haz clic en **Add Credits**.
3. Selecciona el monto que deseas recargar y completa la transacción (acepta tarjeta de crédito/débito y otros medios según la región).

> 💡 **Tip:** Puedes configurar límites de consumo mensuales (*Monthly Limit*) dentro del panel para evitar gastos imprevistos.

---

### 3. Crear y Obtener tu API Key

1. Dirígete a la sección de **API Keys** (`https://openrouter.ai/keys`).
2. Haz clic en el botón **Create Key**.
3. Asigna un nombre descriptivo a tu clave (por ejemplo: `Laravel App Local` o `Production App`).
4. *(Opcional)* Puedes establecer un límite de crédito específico (*Credit Limit*) para esa clave individual.
5. Haz clic en **Create**.
6. **Copia la API Key generada de inmediato.** Solo se mostrará una vez por motivos de seguridad.

---

### 4. Configurar la API Key en tu Proyecto (Laravel)

Añade la clave generada a tu archivo `.env` en la raíz del proyecto:

```env
OPENROUTER_API_KEY=sk-or-v1-tu-clave-generada-aqui
```

> Luego, verifica que en tu archivo config/services.php esté registrada la configuración para leerla:

```php
  'openrouter' => [
      'key' => env('OPENROUTER_API_KEY'),
  ],
```

## 🤖 Integración con Vercel AI SDK y OpenRouter

### 1. Instalación de Dependencias (Frontend)

En la raíz de tu proyecto, instala los paquetes de Vercel AI SDK para React:

```bash
npm install ai @ai-sdk/react
```

### 2. Configuración del Backend (Laravel)

Crea un controlador que reciba los mensajes del chat y se comunique con OpenRouter (puedes usar streaming o respuesta estándar).

En app/Http/Controllers/AiChatController.php:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChatController extends Controller
{
    public function chat(Request $request)
    {
        $validated =$request->validate([
            'messages' => ['required', 'array'],
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openrouter.key'),
            'HTTP-Referer'  => config('app.url'),
            'X-Title'       => config('app.name'),
            'Content-Type'  => 'application/json',
        ])->post('[https://openrouter.ai/api/v1/chat/completions](https://openrouter.ai/api/v1/chat/completions)', [
            'model'    => 'anthropic/claude-3.5-sonnet', // O el modelo de tu preferencia
            'messages' => $validated['messages'],
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Error al conectar con OpenRouter'], 500);
        }

        $data =$response->json();
        
        // Devolvemos el formato que espera el cliente
        return response()->json([
            'message' => [
                'role'    => 'assistant',
                'content' => $data['choices'][0]['message']['content'] ?? ''
            ]
        ]);
    }
}
```

> Registra la ruta en tu archivo de rutas (por ejemplo, routes/web.php o routes/api.php)

```php
use App\Http\Controllers\AiChatController;

Route::post('/ai/chat', [AiChatController::class, 'chat']);
```

## Selección de Modelos Disponibles en OpenRouter

> En la documentación oficial de OpenRouter, puedes encontrar una lista completa de modelos disponibles, sus capacidades y costos asociados. Algunos modelos populares incluyen:

- **anthropic/claude-3.5-sonnet**: Modelo de lenguaje avanzado, ideal para tareas de conversación y generación de texto.
- **google/gemma-4-26b-a4b-it**: Modelo de lenguaje de código abierto, adecuado para tareas de programación y generación de texto.
- **nvidia/nemotron-3-ultra-550b-a55b**: Modelo de lenguaje de alto rendimiento, recomendado para aplicaciones que requieren respuestas rápidas y precisas.
- **cohere/north-mini-code**: Modelo optimizado para generación de código y tareas relacionadas con programación.

Para selecccionar un modelo y ultilizarlo en tu proyecto, simplemente reemplaza el valor del campo `model` en la solicitud HTTP a OpenRouter con el nombre del modelo deseado.

Ubicación de la documentación oficial de OpenRouter: [https://docs.openrouter.ai](https://docs.openrouter.ai) en la pestaña **Models**.

Por ejemplo, en tu controlador de Laravel, puedes cambiar el modelo de la siguiente manera:

```php
    return $agent->stream(
        $prompt,
        provider: 'openrouter',
        model: 'google/gemma-4-26b-a4b-it:free',
        // model: 'nvidia/nemotron-3-ultra-550b-a55b:free',
        // model: 'cohere/north-mini-code:free'
    )->usingVercelDataProtocol();
```
