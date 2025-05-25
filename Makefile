build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

bash:
	docker exec -it excel_app bash

composer-install:
	docker exec -it excel_app composer install

migrate:
	docker exec -it excel_app php artisan migrate

seed:
	docker exec -it excel_app php artisan db:seed

restart:
	docker-compose restart

logs:
	docker-compose logs -f