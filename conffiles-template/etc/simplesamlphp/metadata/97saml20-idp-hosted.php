@!@
hostname = configRegistry.get('hostname')
domainname = configRegistry.get('domainname')
entity_id = configRegistry.get('saml/idp/entityID',
    'https://{0!s}.{1!s}/simplesamlphp/saml2/idp/metadata.php'.format(hostname, domainname))

# Here are defined the default values
privacyideaServerURL = configRegistry.get('privacyidea/saml/privacyideaServerURL', 'https://privacyidea')
sslVerifyHost = configRegistry.get('privacyidea/saml/sslVerifyHost', 'true')
sslVerifyPeer = configRegistry.get('privacyidea/saml/sslVerifyPeer', 'true')
enabledPath = configRegistry.get('privacyidea/saml/enabledPath', 'privacyIDEA')
enabledKey = configRegistry.get('privacyidea/saml/enabledKey', 'enabled')
authenticationFlow = configRegistry.get('privacyidea/saml/authenticationFlow', 'default')
serviceAccount = configRegistry.get('privacyidea/saml/serviceAccount', '')
servicePass = configRegistry.get('privacyidea/saml/servicePass', '')
otpFieldHint = configRegistry.get('privacyidea/saml/otpFieldHint', 'Please enter the OTP')
SSO = configRegistry.get('privacyidea/saml/SSO', 'false')
preferredTokenType = configRegistry.get('privacyidea/saml/preferredTokenType', 'otp')
doEnrollToken = configRegistry.get('privacyidea/saml/doEnrollToken', 'false')
tokenType = configRegistry.get('privacyidea/saml/tokenType', '')
tryFirstAuthentication = configRegistry.get('privacyidea/saml/tryFirstAuthentication', 'false')
tryFirstAuthPass = configRegistry.get('privacyidea/saml/tryFirstAuthentication', '')

excludeEntityIDs = configRegistry.get('privacyidea/saml/excludeEntityIDs', '')
includeAttributes = configRegistry.get('privacyidea/saml/includeAttributes', '')
setPath = configRegistry.get('privacyidea/saml/setPath', 'privacyIDEA')
setKey = configRegistry.get('privacyidea/saml/setKey', 'enabled')

excludeClientIPs = configRegistry.get('privacyidea/saml/excludeClientIPs', '')

realm = configRegistry.get('privacyidea/saml/realm', '')
uidKey = configRegistry.get('privacyidea/saml/uidKey', 'uid')

enabled = configRegistry.get('privacyidea/saml/enable', 'false')

if enabled == 'authsource' or configRegistry.is_true('privacyidea/saml/enable'):
    print("$metadata['{entity_id}']['auth'] = 'privacyidea';".format(entity_id=entity_id))
elif enabled == 'authproc':
    print("$metadata['{entity_id}']['authproc'] = array(".format(entity_id=entity_id))

    print("""
    25 => array(
        'class' => 'privacyidea:PrivacyideaAuthProc',
        'privacyideaServerURL' => '{privacyideaServerURL}',
        'realm' => '{realm}',
        'uidKey' => '{uidKey}',
        'sslVerifyHost' => '{sslVerifyHost}',
        'sslVerifyPeer' => '{sslVerifyPeer}',
        'enabledPath' => '{enabledPath}',
        'enabledKey' => '{enabledKey}',
        'authenticationFlow' => '{authenticationFlow}',
        'serviceAccount' => '{serviceAccount}',
        'servicePass' => '{servicePass}',
        'otpFieldHint' => '{otpFieldHint}',
        'SSO' => '{SSO}',
        'preferredTokenType' => '{preferredTokenType}',
        'doEnrollToken' => '{doEnrollToken}',
        'tokenType' => '{tokenType}',
        'tryFirstAuthentication' => '{tryFirstAuthentication}',
        'tryFirstAuthPass' => '{tryFirstAuthPass}',
""".format(privacyideaServerURL=privacyideaServerURL, realm=realm, uidKey=uidKey, sslVerifyHost=sslVerifyHost.lower(),
            sslVerifyPeer=sslVerifyPeer.lower(), enabledPath=enabledPath, enabledKey=enabledKey,
            authenticationFlow=authenticationFlow, serviceAccount=serviceAccount, servicePass=servicePass,
            otpFieldHint=otpFieldHint, SSO=SSO.lower(), preferredTokenType=preferredTokenType,
            doEnrollToken=doEnrollToken, tokenType=tokenType,
            tryFirstAuthentication=tryFirstAuthentication.lower(), tryFirstAuthPass=tryFirstAuthPass))

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
        """.format(excludeEntityIDs=excludeEntityIDs, includeAttributes=includeAttributes, setPath=setPath, setKey=setKey))
    print("),);")
@!@
