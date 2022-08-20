ssh_fpm:
	docker-compose exec -u root fpm_console bash -l
dsu:
	docker-compose exec -u root fpm_console bash -c "php tests/Functional/console d:s:u --force"
cc:
	docker-compose exec -u root fpm_console bash -c "php tests/Functional/console c:c"

test_coverage:
	docker-compose exec -u root fpm_console bash -c "XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-text  tests"

test_dox:
	docker-compose exec -u root fpm_console bash -c "./vendor/bin/phpunit --testdox tests"
test:
	docker-compose exec -u root fpm_console bash -c "./vendor/bin/phpunit  tests"