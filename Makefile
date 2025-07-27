PHP_SERVICE=php
ARGUMENTS=$(filter-out $@,$(MAKECMDGOALS))

build:
	@docker compose build
up:
	@docker compose up -d
down:
	@docker compose down
rebuild: down build up
restart: down up
symfony:
	@docker compose exec ${PHP_SERVICE} symfony $(ARGUMENTS)
console:
	@docker compose exec ${PHP_SERVICE} symfony console $(ARGUMENTS)
bash:
	@docker compose exec -ti ${PHP_SERVICE} bash
composer:
	@docker compose exec ${PHP_SERVICE} composer $(ARGUMENTS)
phpunit:
	@docker compose exec ${PHP_SERVICE} php bin/console doctrine:database:drop --env=test --force --if-exists
	@docker compose exec ${PHP_SERVICE} php bin/console doctrine:database:create --env=test
	@docker compose exec ${PHP_SERVICE} php bin/console doctrine:migrations:migrate --env=test --no-interaction
	@docker compose exec ${PHP_SERVICE} php vendor/bin/phpunit $(ARGUMENTS) --testdox
phpunit-filter:
	@docker compose exec ${PHP_SERVICE} php vendor/bin/phpunit --testdox --filter $(filter-out $@,$(MAKECMDGOALS))
migrate:
	@docker compose exec ${PHP_SERVICE} php bin/console doctrine:migrations:migrate --no-interaction
db-rebuild:
	@docker compose exec ${PHP_SERVICE} php bin/console doctrine:database:drop --force --if-exists
	@docker compose exec ${PHP_SERVICE} php bin/console doctrine:database:create
	@docker compose exec ${PHP_SERVICE} php bin/console doctrine:migrations:migrate --no-interaction
	@docker compose exec ${PHP_SERVICE} php bin/console doctrine:fixtures:load --no-interaction