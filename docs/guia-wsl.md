# CashTackr

TODO: Explicación del proyecto.

[← Volver al README Principal](../README.md)

---

## 🐧 Desarrollo Ultra-Rápido con WSL2 (Windows 11 / 10 + Ubuntu)

> Si desarrollas desde **Windows**, se recomienda ejecutar este proyecto dentro del sistema de archivos nativo de **Linux (WSL2)** en lugar del sistema de archivos de Windows (`C:\...`).

## ⚡ ¿Por qué mover el proyecto a WSL2?

- **Recarga instantánea con Vite (HMR):** Al guardar archivos `.vue` o `.jsx`, los cambios se reflejan en **menos de 100ms** (en `C:\` puede tardar varios segundos por el cuello de botella I/O entre NTFS y Linux).
- **Cero consumo excesivo de CPU:** Permite desactivar `usePolling: true` en Vite.
- **Compatibilidad nativa:** Evita fallos de lectura/escritura en `node_modules` y carpetas de caché.

### Tip en Solución de Problemas (WSL2 / Git line endings)

> 💡 **Tip:** Si algún script de bash (`.sh`) falla al ejecutarse dentro de un contenedor en WSL2, asegúrate de guardar el archivo con saltos de línea estilo Linux (**LF**) en lugar de Windows (**CRLF**).

### 📂 1. Ubicación Correcta del Proyecto

El proyecto **DEBE** estar clonado/guardado dentro del directorio de usuario de Ubuntu:

| Entorno                  | Ruta del Proyecto                                                | Rendimiento          |
| :----------------------- | :--------------------------------------------------------------- | :------------------- |
| ❌ **Incorrecto (NTFS)** | `/mnt/c/Apps-Laravel/CashTackr` (o `C:\Apps-Laravel\CashTackr`)    | Muy Lento            |
| **Correcto (Linux)**     | `~/proyectos/CashTackr` (o `/home/tu_usuario/proyectos/CashTackr`) | **Velocidad Nativa** |

#### ¿Cómo copiar el proyecto a la ruta nativa de Linux?

Desde tu terminal de **Ubuntu (WSL)**:

```bash
# Crear directorio de proyectos
mkdir -p ~/proyectos

# Copiar el proyecto excluyendo carpetas pesadas/temporales
rsync -av --exclude='src/storage' --exclude='src/vendor' --exclude='src/node_modules' --exclude='.git' /mnt/c/RutaDeTuProyecto/ ~/proyectos/CashTackr/

# Entrar al proyecto
cd ~/proyectos/CashTackr
```

### 💻 2. Trabajo en VS Code desde WSL2

1. Abre tu terminal de `Ubuntu`

2. Navega al proyecto y abre VS Code:

```bash
cd ~/proyectos/CashTackr
code .
```

1. VS Code abrirá conectado de forma nativa a `Ubuntu` (verás la etiqueta azul/verde `WSL: Ubuntu` en la esquina inferior izquierda)

**💡 Tip para el Explorador de Archivos de Windows:**

_Si quieres ver o manipular las carpetas desde Windows, presiona `Win + R` y escribe_ **`\\wsl$\Ubuntu\home\tu_usuario\proyectos\CashTackr`**

### 🛠️ 3. Solución de Problemas Comunes en WSL2

Error de Permisos en Laravel (`Permission denied` en `laravel.log` o `storage`)
Si Docker o PHP no pueden escribir en la carpeta `storage` al mover el proyecto, otorga permisos globales a las carpetas temporales desde Ubuntu

```bash
  cd ~/proyectos/CashTackr/src
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
  cd ~/proyectos/CashTackr
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
rm -rf CashTackr
```

> 🛑 Atención: El comando `rm -rf` elimina la carpeta permanentemente y sin pasar por la papelera de reciclaje de Windows. Asegúrate de haber guardado tus cambios o subido tu código a un repositorio de Git antes de ejecutarlo.

##### 💡 Alternativa: Eliminar desde el Explorador de Archivos de Windows

Si prefieres eliminar los archivos mediante la interfaz gráfica de Windows después de haber ejecutado `docker compose down -v`:

1. Presiona `Win + R`.
2. Escribe la ruta de red de tu usuario en WSL: **`\\wsl$\Ubuntu\home\tu_usuario\proyectos`**
3. Haz clic derecho sobre la carpeta del proyecto (**CashTackr**) y selecciona `Eliminar`
