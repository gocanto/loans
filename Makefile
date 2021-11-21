.PHONY: install test

install:
	cp .env.example .env
	composer install
	php artisan key:generate
	php artisan migrate:refresh --seed
	make test

test:
	./vendor/bin/phpunit
