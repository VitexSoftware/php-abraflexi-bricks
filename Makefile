repoversion=$(shell LANG=C aptitude show php-vitexsoftware-abraflexi-bricks | grep Version: | awk '{print $$2}')
nextversion=$(shell echo $(repoversion) | perl -ne 'chomp; print join(".", splice(@{[split/\./,$$_]}, 0, -1), map {++$$_} pop @{[split/\./,$$_]}), "\n";')


clean:
	rm -rf debian/php-vitexsoftware-abraflexi-bricks
	rm -rf debian/php-vitexsoftware-abraflexi-bricks-doc
	rm -rf debian/*.log
	rm -rf debian/*.substvars
	rm -rf docs/*
	rm -rf vendor/* composer.lock

doc:
	VERSION=`cat debian/composer.json | grep version | awk -F'"' '{print $$4}'`; \
	php -f /usr/bin/apigen generate --source src --destination docs --title "php-vitexsoftware-abraflexi-bricks ${VERSION}" --charset UTF-8 --access-levels public --access-levels protected --php --tree

phpunit:
	composer update
	./vendor/bin/phpunit --bootstrap tests/bootstrap.php

changelog:
	VERSION=`cat debian/composer.json | grep version | awk -F'"' '{print $$4}'`; \
	CHANGES=`git log -n 1 | tail -n+5` ; dch -b -v $${VERSION} --package php-vitexsoftware-abraflexi-bricks "$(CHANGES)"

deb: changelog
	dpkg-buildpackage -A -us -uc

rpm:
	rpmdev-bumpspec --comment="Build" --userstring="Vítězslav Dvořák <info@vitexsoftware.cz>" php-vitexsoftware-abraflexi-bricks.spec
	rpmbuild -ba abraflexi.spec 

verup:
	git commit debian/composer.json debian/version debian/revision  -m "`cat debian/version`-`cat debian/revision`"
	git push origin master

release:
	echo Release v$(nextversion)
	dch -v $(nextversion) `git log -1 --pretty=%B | head -n 1`
	debuild -i -us -uc -b
	git commit -a -m "Release v$(nextversion)"
	git tag -a $(nextversion) -m "version $(nextversion)"


.PHONY : install
	
