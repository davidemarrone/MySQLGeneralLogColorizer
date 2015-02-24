all:	mysql-general-log-colorizer.phar
	@echo "--> Success"

mysql-general-log-colorizer.phar: checkdep clean build


checkdep:
	@echo "--> Checking for composer command line tool"
	@command -v composer >/dev/null && continue || { echo "Composer command not found, install from: https://getcomposer.org/"; exit 1; }
	@echo "--> Checking for box command line tool"
	@command -v box >/dev/null && continue || { echo "Box command not found, install from http://box-project.org/"; exit 1; }

clean:
	@echo "--> Cleaning vendor directory"
	@rm -Rfv vendor
	@echo "--> Installing dependencies without dev"
	composer install --no-dev
	@echo "--> Remove old phar"
	rm -fv mysql-general-log-colorizer.phar

build:
	@echo "--> Building Phar"
	box build

