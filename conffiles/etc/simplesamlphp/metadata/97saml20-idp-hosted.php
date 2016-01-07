@!@
entity_id = configRegistry.get('saml/idp/entityID',
		'https://%(hostname)s.%(domainname)s/simplesamlphp/saml2/idp/metadata.php'
		% configRegistry)
if configRegistry.is_true('privacyidea/saml/enable'):
	print "$metadata['%s']['auth'] = 'privacyidea';" % (entity_id,)
@!@

