# This Makefile is part of JuMiLDAP
#
# global parameters
TITLE="JuMiLDAP"
URL="http://github.com/kichkasch/jumildap"
PACKAGE_NAME ="jumildap"
VERSION="0.1"

# NO leading slash!!!
WEBSERVER_DATAFOLDER="var/www/"
WEBSERVER_SUBFOLDER="jumildap"

clean:
	rm -f *~ languages/*~

sdist: clean 
	tar cf build/tmp.tar *.php *.css COPYING README img languages/*.php
	mkdir $(PACKAGE_NAME)-$(VERSION)
	(cd $(PACKAGE_NAME)-$(VERSION) && tar -xf ../build/tmp.tar)
	rm build/tmp.tar
	tar czf build/$(PACKAGE_NAME)-src-$(VERSION).tar.gz $(PACKAGE_NAME)-$(VERSION)
	rm -rf $(PACKAGE_NAME)-$(VERSION)


# instructions for building Desktop packages
# 1. Ubuntu deb
# (install with: sudo dpkg -i jumildap-$VERSION.deb)
dist: clean
	mkdir -p build/ubuntu/DEBIAN
	cp build/control build/ubuntu/DEBIAN/control
	mkdir -p build/ubuntu/$(WEBSERVER_DATAFOLDER)/$(WEBSERVER_SUBFOLDER)
	cp *.php *.css COPYING README build/ubuntu/$(WEBSERVER_DATAFOLDER)/$(WEBSERVER_SUBFOLDER)
	cp -r img languages build/ubuntu/$(WEBSERVER_DATAFOLDER)/$(WEBSERVER_SUBFOLDER)
	cd build && dpkg --build ubuntu/ $(PACKAGE_NAME)-$(VERSION).deb
	rm -rf build/ubuntu