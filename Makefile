.PHONY: test
test:
	vendor/bin/phpunit tests/RunTest.php

.PHONY: run
run:
	php run.php

.PHONY: install
install:
	composer install