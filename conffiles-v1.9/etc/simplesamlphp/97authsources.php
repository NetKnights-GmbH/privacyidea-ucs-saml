// privacyIDEA authsource
@!@
url = configRegistry.get('privacyidea/saml/url', 'https://privacyidea')
realm = configRegistry.get('privacyidea/saml/realm', '')
verifyhost = configRegistry.get('privacyidea/saml/verifyhost', 'true')
verifypeer = configRegistry.get('privacyidea/saml/verifypeer', 'true')
print("""
$config['privacyidea'] = array(
                'privacyidea:PrivacyideaAuthSource',
                'privacyideaServerURL' => '{url}',
                'sslVerifyHost' => {verifyhost},
                'sslVerifyPeer' => {verifypeer},
                'realm' => '{realm}',
                'attributemap' => array('username' => 'uid',
                                        'surname' => 'surName',
                                        'givenname' => 'givenName',
                                        'email' => 'emailAddress',
                                        'phone' => 'telePhone',
                                        'mobile' => 'mobilePhone'),
		);
""".format(url=url, verifyhost=verifyhost.lower(), verifypeer=verifypeer.lower(), realm=realm))
@!@
