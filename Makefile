init: docker-down docker-pull docker-build docker-up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

app-init: app-install-composer

app-install-composer:
	docker-compose run --rm php-cli composer install

app-migrate:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate

app-test:
	docker-compose run --rm php-cli php artisan test

composer-update:
	yes | docker-compose run --rm php-cli composer update

db-fresh: migrate-fresh db-seed

migrate-fresh:
	run --rm php-cli php artisan migrate:fresh

db-seed:
	docker-compose run --rm php-cli php artisan db:seed && docker-compose run --rm php-cli php artisan module:seed

doc-generate:
	docker-compose run --rm php-cli php artisan  l5-swagger:generate

storage-link:
	docker-compose run --rm php-cli php artisan  storage:link

migrate-seed:
	php artisan migrate:fresh && php artisan module:seed

optimize:
	php artisan optimize && php artisan serve
