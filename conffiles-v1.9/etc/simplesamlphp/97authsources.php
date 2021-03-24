// privacyIDEA authsource
@!@
url = configRegistry.get('privacyidea/saml/url', 'https://privacyidea')
realm = configRegistry.get('privacyidea/saml/realm', '')
verifyhost = configRegistry.get('privacyidea/saml/verifyhost', 'True')
verifypeer = configRegistry.get('privacyidea/saml/verifypeer', 'True')
print("""
$config['privacyidea'] = array(
                'privacyidea:privacyidea',
                'privacyideaserver' => '{url}',
                'sslverifyhost' => {verifyhost},
                'sslverifypeer' => {verifypeer},
                'realm' => '{realm}',
                'attributemap' => array('username' => 'uid',
                                        'surname' => 'surName',
                                        'givenname' => 'givenName',
                                        'email' => 'emailAddress',
                                        'phone' => 'telePhone',
                                        'mobile' => 'mobilePhone'),
		);
""".format(url=url, verifyhost=verifyhost, verifypeer=verifypeer, realm=realm))
@!@
