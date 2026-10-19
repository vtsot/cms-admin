COMPOSE = docker compose
PHP     = $(COMPOSE) exec -it php-fpm
NODE    = $(COMPOSE) exec -it nodejs
MYSQL   = $(COMPOSE) exec -it mysql mysql

.DEFAULT_GOAL := help

## --- Docker ---------------------------------------------------------------
docker-build: ## Build all Docker images
	$(COMPOSE) build

docker-up: ## Build (if needed) and start all containers in the background
	$(COMPOSE) up --build -d

docker-stop: ## Stop all containers without removing them
	$(COMPOSE) stop

docker-down: ## Stop and remove all containers
	$(COMPOSE) down

docker-restart: ## Restart all containers
	$(COMPOSE) restart

docker-ps: ## List container status
	$(COMPOSE) ps

docker-logs: ## Follow logs from all containers
	$(COMPOSE) logs -f

## --- Shells -----------------------------------------------------------------

php-console: ## Open a shell in the php-fpm container
	$(PHP) /bin/bash

node-console: ## Open a shell in the nodejs container
	$(NODE) /bin/sh

mysql-console:
	#docker compose -f ./.docker/docker-compose.yaml exec -it mysql mysql -u root -p"password"
	$(MYSQL) -u root -p"password"

## --- Logs -----------------------------------------------------------------

php-logs:
	$(COMPOSE) logs -f php-fpm

node-logs:
	$(COMPOSE) logs -f nodejs

mysql-logs:
	$(COMPOSE) logs -f mysql

## --- Backend (PHP/Symfony) --------------------------------------------------

install: ## Install PHP dependencies via Composer
	$(PHP) composer install

update: ## Update PHP dependencies via Composer
	$(PHP) composer update

migrate: ## Run Doctrine migrations (dev and test environments)
	$(PHP) ./bin/console doctrine:migrations:migrate --no-interaction
	$(PHP) ./bin/console doctrine:migrations:migrate --env=test --no-interaction

fixtures: ## Load database fixtures
	$(PHP) ./bin/console doctrine:fixtures:load --no-interaction

cache-clear: ## Clear the Symfony cache
	$(PHP) ./bin/console cache:clear --no-warmup
	$(PHP) ./bin/console cache:clear --env=test --no-interaction

#routes-dump: ## Regenerate the JS routing dump (run after route changes)
#	$(PHP) ./bin/console fos:js-routing:dump

jwt-keys: ## Generate the JWT authentication keypair (one-time setup)
	$(PHP) ./bin/console lexik:jwt:generate-keypair

test: ## Run the full Codeception test suite
	$(PHP) composer run test

test-acceptance: ## Run acceptance tests in the selenium container (watch at http://localhost:7900; ARGS="LoginPageCest" to filter)
	$(COMPOSE) up -d selenium nginx
	@for i in $$(seq 1 30); do \
		$(COMPOSE) exec -T php-fpm curl -s http://selenium:4444/status | grep -q '"ready": *true' && break; \
		sleep 2; \
	done
	@(xdg-open "http://localhost:7900/?autoconnect=1&resize=scale" || open "http://localhost:7900/?autoconnect=1&resize=scale") >/dev/null 2>&1 &
	$(COMPOSE) exec -T php-fpm php -d pcov.enabled=1 -d memory_limit=-1 ./vendor/bin/codecept run acceptance $(ARGS)

test-api: ## Run only the API Codeception test suite
	$(PHP) composer run test:api

test-unit: ## Run only the Unit Codeception test suite
	$(PHP) composer run test:unit

test-web: ## Run only the Web Codeception test suite
	$(PHP) composer run test:web

test-coverage: ## Run all suites with HTML coverage
	$(PHP) composer run test:coverage

test-coverage-html: ## Run all suites except acceptance and web with HTML coverage (tests/_output/coverage)
	$(PHP) composer run test:coverage-html

lint:
	$(PHP) composer run lint

lint-fix:
	$(PHP) composer run lint:fix

#translations:
#	$(PHP) ./bin/console app:translation:import ./var/translations.yaml
#	$(PHP) ./bin/console app:cache:translation:clear

## --- Frontend (Vue/Webpack Encore) -------------------------------------------

yarn-install: ## Install JS dependencies via Yarn
	$(NODE) yarn install

yarn-dev: ## Build frontend assets for development
	$(NODE) yarn dev

yarn-watch: ## Build frontend assets and watch for changes
	$(NODE) yarn watch

yarn-build: ## Build frontend assets for production
	$(NODE) yarn build

## --- Help ---------------------------------------------------------------------

help: ## Show this help message
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-16s\033[0m %s\n", $$1, $$2}'

.PHONY: test-acceptance test-coverage-html test-web-api test-web-api-coverage docker-build docker-up docker-stop docker-down docker-restart docker-ps docker-logs \
	php-console node-console install update migrate fixtures cache-clear routes-dump jwt-keys \
	test test-api yarn-install yarn-dev yarn-watch yarn-build help

