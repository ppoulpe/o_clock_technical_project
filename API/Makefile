DC=docker-compose
PHP_CONTAINER=app_oclock_php
EXEC=docker exec -it $(PHP_CONTAINER)

start: # Start all existing containers
	@$(DC) start

stop: # stop all existing containers
	@$(DC) stop

up:
	@$(DC) up -d

up-with-build:
	@$(DC) up -d --build

bash:
	@$(EXEC) bash

phpunit:
	@$(EXEC) php bin/console --env=test doctrine:fixtures:load -n
	@$(EXEC) php vendor/bin/phpunit --coverage-html=build/coverage

install: composer-install init-db init-test-db

composer-install:
	@$(EXEC) composer install

reset:
	@$(DC) stop
	@$(DC) rm -f
	@docker volume prune -f
	@$(DC) up --build -d


init-db:
	@$(EXEC) php bin/console doctrine:migrations:migrate --no-interaction

init-test-db:
	@$(EXEC) php bin/console doctrine:migrations:migrate --env=test --no-interaction

down:
	@$(DC) down

cs-fixer-dry-run: # List all files to fix
	@$(EXEC) vendor/bin/php-cs-fixer fix src --dry-run

cs-fixer: # run cs-fixer
	 @$(EXEC) vendor/bin/php-cs-fixer fix src

phpstan:
	@$(EXEC) vendor/bin/phpstan analyse src

