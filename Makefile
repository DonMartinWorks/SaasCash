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

destroy:
	@echo "¡ADVERTENCIA! Eliminando absolutamente todo el sistema Docker local..."
	docker compose down -v --rmi all
	docker system prune -a --volumes -f
	docker builder prune -a -f