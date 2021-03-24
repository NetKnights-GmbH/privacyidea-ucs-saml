// privacyIDEA authsource
@!@
hostname = configRegistry.get('hostname')
domainname = configRegistry.get('domainname')
url = configRegistry.get('privacyidea/saml/url', 'https://%s.%s/privacyidea' % (hostname, domainname))
realm = configRegistry.get('privacyidea/saml/realm', '')
verifyhost = configRegistry.get('privacyidea/saml/verifyhost', 'True')
verifypeer = configRegistry.get('privacyidea/saml/verifypeer', 'True')
print """
$config['privacyidea'] = array(
                'privacyidea:privacyidea',
                'privacyideaserver' => '%s',
                'sslverifyhost' => %s,
                'sslverifypeer' => %s,
                'realm' => '%s',
                'attributemap' => array('username' => 'uid',
                                        'surname' => 'surName',
                                        'givenname' => 'givenName',
                                        'email' => 'emailAddress',
                                        'phone' => 'telePhone',
                                        'mobile' => 'mobilePhone'),
		);
""" % (url, verifyhost, verifypeer, realm)
@!@
