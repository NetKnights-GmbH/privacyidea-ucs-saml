@!@
hostname = configRegistry.get('hostname')
domainname = configRegistry.get('domainname')
entity_id = configRegistry.get('saml/idp/entityID',
		'https://{0!s}.{1!s}/simplesamlphp/saml2/idp/metadata.php'.format(hostname, domainname))

url = configRegistry.get('privacyidea/saml/url', 'https://privacyidea')
verifyhost = configRegistry.get('privacyidea/saml/verifyhost', 'true')
verifypeer = configRegistry.get('privacyidea/saml/verifypeer', 'true')
enabledPath = configRegistry.get('privacyidea/saml/enabledPath', 'privacyIDEA')
enabledKey = configRegistry.get('privacyidea/saml/enabledKey', 'enabled')

excludeEntityIDs = configRegistry.get('privacyidea/saml/excludeEntityIDs', '')
includeAttributes = configRegistry.get('privacyidea/saml/includeAttributes', '')
setPath = configRegistry.get('privacyidea/saml/setPath', 'privacyIDEA')
setKey = configRegistry.get('privacyidea/saml/setKey', 'enabled')

excludeClientIPs = configRegistry.get('privacyidea/saml/excludeClientIPs', '')

realm = configRegistry.get('privacyidea/saml/realm', '')
uidKey = configRegistry.get('privacyidea/saml/uidkey', 'uid')

enabled = configRegistry.get('privacyidea/saml/enable', 'false')

if enabled == 'authsource' or configRegistry.is_true('privacyidea/saml/enabled'):
	print("$metadata['{entity_id}']['auth'] = 'privacyidea';".format(entity_id))
elif enabled == 'authproc':
	print("""
    $metadata['{entity_id}']['authproc'] = array(
    """.format(entity_id=entity_id))

	print("""
		25 => array(
			'class' => 'privacyidea:PrivacyideaAuthProc',
			'realm' => '{realm}',
			'uidKey' => '{uidKey}',
            'sslVerifyHost' => '{verifyhost}',
            'sslVerifyPeer' => '{verifypeer}',
    """.format(realm=realm, uidKey=uidKey, verifyhost=verifyhost.lower(), verifypeer=verifypeer.lower()))

if excludeClientIPs != '':
        print("""
            'excludeClientIPs' => {excludeClientIPs},
        """.format(excludeClientIPs=excludeClientIPs))

if excludeEntityIDs != '':
        print("""
            'checkEntityID' => 'true',
            'excludeEntityIDs' => {excludeEntityIDs},
            'includeAttributes' => {includeAttributes},
            'setPath' => '{setPath}',
            'setKey' => '{setKey}',
            """.format(excludeEntityIDs=excludeEntityIDs,
                          includeAttributes=includeAttributes,
                          setPath=setPath,
                          setKey=setKey))
            
	print("),);")
@!@
