// privacyIDEA authsource
@!@
url = configRegistry.get('privacyidea/saml/url', 'https://privacyidea')
realm = configRegistry.get('privacyidea/saml/realm', '')
verifyhost = configRegistry.get('privacyidea/saml/verifyhost', 'true')
verifypeer = configRegistry.get('privacyidea/saml/verifypeer', 'true')
doTriggerChallenge = configRegistry.get('privacyidea/saml/doTriggerChallenge', 'false')
serviceAccount = configRegistry.get('privacyidea/saml/serviceAccount', 'service')
servicePass = configRegistry.get('privacyidea/saml/servicePass', 'service')
doSendPassword = configRegistry.get('privacyidea/saml/doSendPassword', 'false')
otpFieldHint = configRegistry.get('privacyidea/saml/otpFieldHint', 'Please enter OTP')
passFieldHint = configRegistry.get('privacyidea/saml/passFieldHint', 'Please enter password')
SSO = configRegistry.get('privacyidea/saml/SSO', 'false')
preferredTokenType = configRegistry.get('privacyidea/saml/preferredTokenType', 'otp')
print("""
$config['privacyidea'] = array(
                'privacyidea:PrivacyideaAuthSource',
                'privacyideaServerURL' => '{url}',
                'sslVerifyHost' => {verifyhost},
                'sslVerifyPeer' => {verifypeer},
                'realm' => '{realm}',
                'doTriggerChallenge' => '{doTriggerChallenge}',
                'serviceAccount' => '{serviceAccount}',
                'servicePass' => '{servicePass}',
                'doSendPassword' => '{doSendPassword}',
                'otpFieldHint' => '{otpFieldHint}',
                'passFieldHint' => '{passFieldHint}',
                'SSO' => '{SSO}',
                'preferredTokenType' => '{preferredTokenType}',
                'attributemap' => array('username' => 'uid',
                                        'surname' => 'surName',
                                        'givenname' => 'givenName',
                                        'email' => 'emailAddress',
                                        'phone' => 'telePhone',
                                        'mobile' => 'mobilePhone'),
		);
""".format(url=url, verifyhost=verifyhost.lower(), verifypeer=verifypeer.lower(), realm=realm,
            doTriggerChallenge=doTriggerChallenge, serviceAccount=serviceAccount, servicePass=servicePass,
            doSendPassword=doSendPassword, otpFieldHint=otpFieldHint, passFieldHint=passFieldHint,
            SSO=SSO.lower(), preferredTokenType=preferredTokenType))
@!@
