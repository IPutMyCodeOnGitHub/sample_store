
run:
	php bin/console server:run

dropdb:
	php bin/console doctrine:database:drop --force

createdb:
	php bin/console doctrine:database:create

migrate:
	php bin/console doctrine:migrations:migrate

loadfixt:
	php bin/console doctrine:fixtures:load

getjwt:
	openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
	openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout