@!@
entity_id = configRegistry.get('saml/idp/entityID',
		'https://%(hostname)s.%(domainname)s/simplesamlphp/saml2/idp/metadata.php'
		% configRegistry)

hostname = baseConfig.get('hostname')
domainname = baseConfig.get('domainname')

url = baseConfig.get('privacyidea/saml/url', 'https://privacyidea')
verifyhost = baseConfig.get('privacyidea/saml/verifyhost', 'True')
verifypeer = baseConfig.get('privacyidea/saml/verifypeer', 'True')
enabledPath = baseConfig.get('privacyidea/saml/enabledPath', 'privacyIDEA')
enabledKey = baseConfig.get('privacyidea/saml/enabledKey', 'enabled')

excludeEntityIDs = baseConfig.get('privacyidea/saml/excludeEntityIDs', 'array()')
includeAttributes = baseConfig.get('privacyidea/saml/includeAttributes', 'array()')
setpath = baseConfig.get('privacyidea/saml/setpath', 'privacyIDEA')
setkey = baseConfig.get('privacyidea/saml/setkey', 'enabled')

checkClientIPs = baseConfig.get('privacyidea/saml/excludeClientIPs', 'array()')

realm = baseConfig.get('privacyidea/saml/realm', '')
uid = baseConfig.get('privacyidea/saml/uidkey', 'uid')
SSO = baseConfig.get('privacyidea/saml/SSO', 'true')

enabled = baseConfig.get('privacyidea/saml/enable', 'false')

if enabled == 'authsource' or enabled.lower() == 'true':
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
