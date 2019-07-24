install:
	composer install

lint:
	composer run-script phpcs -- --standard=PSR12 app/Http/Controllers database tests

lint-fix:
	composer run-script phpcbf -- --standard=PSR12 app/Http/Controllers database tests

test:
	composer run-script phpunit

run:
	php -S localhost:8000 -t public

logs:
	tail -f storage/logs/lumen.log