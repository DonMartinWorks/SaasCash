# CashTackr

TODO: Explicación del proyecto.

[← Volver al README Principal](../README.md)

---

## 🧹 Mantenimiento y Limpieza

> ⚠️ **Nota:** Ejecuta estos comandos desde la carpeta raíz del proyecto (donde reside el archivo `docker-compose.yml`, no en **src**). ⚠️

1. Ejecutándolos desde la carpeta del proyecto (La forma recomendada)

- **Detener los contenedores (sin borrar datos):**

```bash
  docker compose stop
```

- Detener y eliminar contenedores/redes (Conserva datos de la BD):

```bash
  docker compose down
```

- Borrar todo incluyendo la Base de Datos (Reset de Volúmenes):

```bash
  docker compose down -v
```

- Reset Nuclear (Borrado profundo de todo el motor Docker): **⚠️ ¡Cuidado especial con el "Reset Nuclear"!**

```bash
  docker compose down -v --rmi all
  docker system prune -a --volumes -f
```

1. Si estás fuera de la carpeta o quieres ser 100% específico

_Si no estás ubicado dentro de la carpeta del proyecto o quieres asegurarte desde cualquier lugar de la consola de no tocar otra cosa, puedes pasar el flag `-p` **(nombre del proyecto)** o `-f` **(ruta del archivo)**:_

- Usando el nombre del proyecto:

```bash
  docker compose -p mi_app_laravel down -v
```

- Apuntando al archivo docker-compose.yml específico:

```bash
  docker compose -f /ruta/a/tu/proyecto/docker-compose.yml down -v
```
