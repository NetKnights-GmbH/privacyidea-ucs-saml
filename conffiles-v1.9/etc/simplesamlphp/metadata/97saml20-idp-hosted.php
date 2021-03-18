@!@
entity_id = configRegistry.get('saml/idp/entityID',
		'https://%(hostname)s.%(domainname)s/simplesamlphp/saml2/idp/metadata.php'
		% configRegistry)

hostname = configRegistry.get('hostname')
domainname = configRegistry.get('domainname')

url = configRegistry.get('privacyidea/saml/url', 'https://privacyidea')
verifyhost = configRegistry.get('privacyidea/saml/verifyhost', 'True')
verifypeer = configRegistry.get('privacyidea/saml/verifypeer', 'True')
enabledPath = configRegistry.get('privacyidea/saml/enabledPath', 'privacyIDEA')
enabledKey = configRegistry.get('privacyidea/saml/enabledKey', 'enabled')

excludeEntityIDs = configRegistry.get('privacyidea/saml/excludeEntityIDs', 'array()')
includeAttributes = configRegistry.get('privacyidea/saml/includeAttributes', 'array()')
setpath = configRegistry.get('privacyidea/saml/setpath', 'privacyIDEA')
setkey = configRegistry.get('privacyidea/saml/setkey', 'enabled')

checkClientIPs = configRegistry.get('privacyidea/saml/excludeClientIPs', 'array()')

realm = configRegistry.get('privacyidea/saml/realm', '')
uid = configRegistry.get('privacyidea/saml/uidkey', 'uid')
SSO = configRegistry.get('privacyidea/saml/SSO', 'true')

enabled = configRegistry.get('privacyidea/saml/enable', 'false')

if enabled == 'authsource' or configRegistry.is_true('privacyidea/saml/enabled'):
	print "$metadata['%s']['auth'] = 'privacyidea';" % (entity_id,)
elif enabled == 'authproc':
	print """
    $metadata['%s']['authproc'] = array(
		20 => array(
                        'class' => 'privacyidea:serverconfig',
			'privacyideaserver' => '%s',
                        'sslverifyhost' => %s,
			'sslverifypeer' => %s,
                        'enabledPath' => '%s',
                        'enabledKey' => '%s',
		),""" % (entity_id, url, verifyhost, verifypeer, enabledPath, enabledKey)

	if excludeEntityIDs != 'array()':
		print """
		22 => array(
			'class' => 'privacyidea:checkEntityID',
                        'excludeEntityIDs' => %s,
                        'includeAttributes' => %s,
                        'setPath' => '%s',
                        'setKey' => '%s',
		), """ % (excludeEntityIDs, includeAttributes, setpath, setkey)

	if checkClientIPs != 'array()':
		print """
                23 => array(
                        'class' => 'privacyidea:checkClientIP',
                        'checkClientIPs' => %s,
                ), """ % (checkClientIPs)
	print """
		25 => array(
			'class' => 'privacyidea:privacyidea',
			'realm' => '%s',
			'uidKey' => '%s',
			'SSO' => %s,
		), """ % (realm, uid, SSO)
	print ");"
@!@
