clean:
	rm -rf debian/php-flexibee-bricks
	rm -rf debian/php-flexibee-bricks-doc
	rm -rf debian/*.log
	rm -rf debian/*.substvars
	rm -rf docs/*
	rm -rf vendor/* composer.lock

doc:
	VERSION=`cat debian/composer.json | grep version | awk -F'"' '{print $$4}'`; \
	php -f /usr/bin/apigen generate --source src --destination docs --title "php-flexibee-bricks ${VERSION}" --charset UTF-8 --access-levels public --access-levels protected --php --tree

phpunit:
	composer update
	./vendor/bin/phpunit --bootstrap tests/bootstrap.php

changelog:
	VERSION=`cat debian/composer.json | grep version | awk -F'"' '{print $$4}'`; \
	CHANGES=`git log -n 1 | tail -n+5` ; dch -b -v $${VERSION} --package php-flexibee-bricks "$(CHANGES)"

deb: changelog
	dpkg-buildpackage -A -us -uc

rpm:
	rpmdev-bumpspec --comment="Build" --userstring="Vítězslav Dvořák <info@vitexsoftware.cz>" php-flexibee-bricks.spec
	rpmbuild -ba flexipeehp.spec 

verup:
	git commit debian/composer.json debian/version debian/revision  -m "`cat debian/version`-`cat debian/revision`"
	git push origin master

.PHONY : install
	
