
init:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install

stop:
	docker-compose down

createdb:
	docker-compose exec php bin/console doctrine:database:create
	docker-compose exec php bin/console doctrine:migrations:migrate
	docker-compose exec php bin/console doctrine:fixtures:load

run:
	docker-compose exec php bin/console server:run

dropdb:
	docker-compose exec php bin/console doctrine:database:drop --force

migrate:
	docker-compose exec php bin/console doctrine:migrations:migrate

loadfixt:
	docker-compose exec php bin/console doctrine:fixtures:load

getjwt:
	openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
	openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout