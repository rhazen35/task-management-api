setup:
	@echo "Check for existence of .env file and create it from .env.dist if necessary"
	@test -f .env || ( cp .env.dist .env && echo " - .env-File Created. Check the contents and modify it to your own setup.")
	@echo "Development successfully configured:\n - You can now run \"make run\" to start the docker-environment."

install:
	docker-compose exec php-fpm composer install

run:
	docker-compose pull
	docker-compose up --force-recreate

bash:
	docker-compose exec php-fpm bash

install:
	docker-compose exec php-fpm composer install

migrations:
	docker-compose exec php-fpm bin/console do:mi:mi -n

reset-db-with-migrations:
	docker-compose exec php-fpm bin/console do:da:dr --force --if-exists
	docker-compose exec php-fpm bin/console do:da:cr

	make migrations

load-fixtures:
	docker-compose exec php-fpm php -d memory_limit=1G bin/console doctrine:fixtures:load --no-interaction --group dev

reset-db-with-migrations-and-load-fixtures:
	make reset-db-with-migrations
	make load-fixtures

run-php-cs-fixer:
	docker-compose exec php-fpm php -d memory_limit=1G vendor/bin/php-cs-fixer fix --allow-risky=yes

run-phpstan:
	docker-compose exec php-fpm php -d memory_limit=1G vendor/bin/phpstan analyze --level=8 src/ -vv

run-all-code-quality-checks:
	make run-phpstan
	make run-php-cs-fixer