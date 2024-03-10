runup:
	@make setup
	@make data
setup:
	@make build
	@make up 
	@make composer-update
build:
	docker compose build --no-cache --force-rm
stop:
	docker compose stop
up:
	docker compose up -d
composer-update:
	docker exec laravel-docker bash -c "composer update"
data:
	docker exec laravel-docker bash -c "php artisan migrate --force"
	docker exec laravel-docker bash -c "php artisan db:seed"
	docker exec laravel-docker bash -c "chown -R www-data:www-data /var/www/html"

