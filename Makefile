
install: init createdb generate_jwt_keys

init:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install

stop:
	docker-compose down

createdb:
	docker-compose exec php bin/console doctrine:database:drop --force --if-exists
	docker-compose exec php bin/console doctrine:database:create
	docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction
	docker-compose exec php bin/console doctrine:fixtures:load --no-interaction

dropdb:
	docker-compose exec php bin/console doctrine:database:drop --force --if-exists

generate_jwt_keys:
	openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
	openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout