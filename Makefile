init:
	mkdir -p tests/Functional/extra
ssh_fpm:
	docker-compose exec -u root fpm_console bash -l
dsu: init
	docker-compose exec -u root fpm_console bash -c "php tests/Functional/console d:s:u --force"
cc: init
	docker-compose exec -u root fpm_console bash -c "php tests/Functional/console c:c --env=test"
dr: init
	docker-compose exec -u root fpm_console bash -c "php tests/Functional/console debug:router"

test_coverage: cc
	docker-compose exec -u root fpm_console bash -c "XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-text  tests"

test_dox: cc
	docker-compose exec -u root fpm_console bash -c "./vendor/bin/phpunit --testdox tests"
test: cc
	docker-compose exec -u root fpm_console bash -c "./vendor/bin/phpunit  tests"