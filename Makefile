docs: bin/apigen apigen.neon src/Object/*.php
	php bin/apigen generate

bin/apigen:
	php -r 'copy("https://github.com/ApiGen/ApiGen/releases/download/v4.1.2/apigen.phar", "bin/apigen"); chmod("bin/apigen", 0755);'

.PHONY: test
test: src/Object/*.php tests/*.php
	php vendor/bin/phpunit
