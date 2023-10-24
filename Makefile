docs: bin/apigen apigen.neon src/Object/*.php
	php bin/apigen --workers 1

bin/apigen:
	php -r 'copy("https://github.com/ApiGen/ApiGen/releases/download/v7.0.0-alpha.6/apigen.phar", "bin/apigen"); chmod("bin/apigen", 0755);'

.PHONY: test docs
test: src/Object/*.php tests/*.php
	php vendor/bin/phpunit
