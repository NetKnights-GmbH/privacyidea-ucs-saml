@!@
entity_id = configRegistry.get('saml/idp/entityID',
		'https://%(hostname)s.%(domainname)s/simplesamlphp/saml2/idp/metadata.php'
		% configRegistry)

hostname = baseConfig.get('hostname')
domainname = baseConfig.get('domainname')
url = baseConfig.get('privacyidea/saml/url', 'https://%s.%s/privacyidea' % (hostname, domainname))
realm = baseConfig.get('privacyidea/saml/realm', '')
verifyhost = baseConfig.get('privacyidea/saml/verifyhost', 'True')
verifypeer = baseConfig.get('privacyidea/saml/verifypeer', 'True')
uid = baseConfig.get('privacyidea/saml/uidkey', 'uid')
enabled = baseConfig.get('privacyidea/saml/enable')

if enabled == 'authsource' or enabled.lower() == 'true':
	print "$metadata['%s']['auth'] = 'privacyidea';" % (entity_id,)
elif enabled == 'authproc':
	print """
    $metadata['%s']['authproc'] = array(
		25 => array(
			'class' => 'privacyidea:privacyidea',
			'privacyideaserver' => '%s',
			'realm' => '%s',
			'uidKey' => '%s',
			'sslverifyhost' => %s,
			'sslverifypeer' => %s,
		),
	);
	""" % (entity_id, url, realm, uid, verifyhost, verifypeer)
@!@
