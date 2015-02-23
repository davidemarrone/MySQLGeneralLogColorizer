all:
	@echo "Only build-phar target is currently supported."

build-phar:
	@echo "--> Checking for composer command line tool"
	command -v composer >/dev/null && continue || { echo "composer command not found, install from: https://getcomposer.org/"; exit 1; }
	@echo "--> Cleaning vendor directory"
	rm -Rfv vendor
	@echo "--> Installing dependencies without dev"
	composer install --no-dev
	@echo "--> Building Phar"
	command -v box build >/dev/null && continue || { echo "box command not found, install from http://box-project.org/"; exit 1; }
	@echo "--> Success"
