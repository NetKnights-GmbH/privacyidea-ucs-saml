@!@
enabled = configRegistry.get('privacyidea/saml/enable')
entity_id = configRegistry.get('saml/idp/entityID',
		'https://%(hostname)s.%(domainname)s/simplesamlphp/saml2/idp/metadata.php'
		% configRegistry)
if enabled.lower() == "true":
	print "$metadata['%s']['auth'] = 'privacyidea';" % (entity_id,)
@!@

