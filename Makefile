.PHONY: install test

install:
	cp .env.example .env
	composer install
	php artisan key:generate
	make test

test:
	./vendor/bin/phpunit
