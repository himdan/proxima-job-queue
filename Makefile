ssh_fpm:
	docker-compose exec -u root fpm_console bash -l

test_dox:
	docker-compose exec -u root fpm_console bash -c "./vendor/bin/phpunit --testdox tests"
test:
	docker-compose exec -u root fpm_console bash -c "./vendor/bin/phpunit  tests"