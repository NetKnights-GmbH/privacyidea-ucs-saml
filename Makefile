info:
	@echo "make clean        - remove all automatically created files"
	@echo "make builddeb     - build .deb file locally"
	
#VERSION=1.3~dev5
VERSION=1.5
SRCDIRS=debian conffiles simplesamlphp-module-privacyidea/
SRCFILES=Makefile

clean:
	rm -fr DEBUILD
	rm -f meta/*~


builddeb:
	make clean
	mkdir -p DEBUILD/privacyidea-ucs-saml.org
	cp -r ${SRCDIRS} ${SRCFILES} DEBUILD/privacyidea-ucs-saml.org || true
	# We need to touch this, so that our config files 
	# are written to /etc
	(cd DEBUILD; tar -zcf privacyidea-ucs-saml_${VERSION}.orig.tar.gz --exclude=privacyidea.org/debian privacyidea-ucs-saml.org)
	################# Build
	(cd DEBUILD/privacyidea-ucs-saml.org; debuild --no-lintian -uc -us)

