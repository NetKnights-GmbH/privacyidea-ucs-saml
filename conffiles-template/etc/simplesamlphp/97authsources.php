// privacyIDEA authsource
@!@
privacyideaServerURL = configRegistry.get('privacyidea/saml/privacyideaServerURL', 'https://privacyidea')
realm = configRegistry.get('privacyidea/saml/realm', '')
sslVerifyHost = configRegistry.get('privacyidea/saml/sslVerifyHost', 'true')
sslVerifyPeer = configRegistry.get('privacyidea/saml/sslVerifyPeer', 'true')
authenticationFlow = configRegistry.get('privacyidea/saml/authenticationFlow', 'sendPass')
serviceAccount = configRegistry.get('privacyidea/saml/serviceAccount', '')
servicePass = configRegistry.get('privacyidea/saml/servicePass', '')
otpFieldHint = configRegistry.get('privacyidea/saml/otpFieldHint', 'Please enter the OTP')
passFieldHint = configRegistry.get('privacyidea/saml/passFieldHint', 'Please enter the Password')
SSO = configRegistry.get('privacyidea/saml/SSO', 'false')
preferredTokenType = configRegistry.get('privacyidea/saml/preferredTokenType', 'otp')
print("""
$config['privacyidea'] = array(
                'privacyidea:PrivacyideaAuthSource',
                'privacyideaServerURL' => '{privacyideaServerURL}',
                'sslVerifyHost' => {sslVerifyHost},
                'sslVerifyPeer' => {sslVerifyPeer},
                'realm' => '{realm}',
                'authenticationFlow' => '{authenticationFlow}',
                'serviceAccount' => '{serviceAccount}',
                'servicePass' => '{servicePass}',
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
""".format(privacyideaServerURL=privacyideaServerURL, sslVerifyHost=sslVerifyHost.lower(), sslVerifyPeer=sslVerifyPeer.lower(), realm=realm,
authenticationFlow=authenticationFlow, serviceAccount=serviceAccount, servicePass=servicePass,
            otpFieldHint=otpFieldHint, passFieldHint=passFieldHint,
            SSO=SSO.lower(), preferredTokenType=preferredTokenType))
@!@
