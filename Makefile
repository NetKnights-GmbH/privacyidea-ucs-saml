info:
	@echo "make clean        - remove all automatically created files"
	@echo "make builddeb     - build .deb file locally"

ifndef VERSION
        $(error VERSION not set. Set VERSION to build like VERSION=1.7)
	$(error This is a VERSION number is a github tag!)
endif
#VERSION=1.3~dev5
#VERSION=1.6
SRCDIRS=debian conffiles simplesamlphp-module-privacyidea/
SRCFILES=Makefile
DEFAULT_CONFFILES=conffiles-v1.9
VERSION_NUMBER=$(shell echo ${VERSION} | sed 's@^[^0-9\.]*\([0-9\.]\+\).*@\1@')

select-conffiles:
	if [ $(shell echo ${VERSION_NUMBER}\>=1.9 | bc) -eq 1 ]; then \
		echo "Version: $(VERSION). Using conffiles-v1.9"; \
		cp -r conffiles-v1.9 conffiles; \
	else \
		echo "Version smaller than 1.9: $(VERSION). Using conffiles-v1.8."; \
		cp -r conffiles-v1.8 conffiles; \
	fi

clean:
	rm -fr conffiles
	rm -fr DEBUILD
	rm -f meta/*~

builddeb-current:
	make clean
	make select-conffiles
	mkdir -p DEBUILD/privacyidea-ucs-saml.org
	cp -r ${SRCDIRS} DEBUILD/privacyidea-ucs-saml.org || true
	# We need to touch this, so that our config files 
	# are written to /etc
	(cd DEBUILD; tar -zcf privacyidea-ucs-saml_${VERSION}.orig.tar.gz --exclude=privacyidea.org/debian privacyidea-ucs-saml.org)
	################# Build
	(cd DEBUILD/privacyidea-ucs-saml.org; debuild --no-lintian -uc -us)

builddeb:
	(cd simplesamlphp-module-privacyidea/; git pull; git checkout v${VERSION})
	make builddeb-current
