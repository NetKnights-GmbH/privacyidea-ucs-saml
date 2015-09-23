// privacyIDEA authsource
@!@
hostname = baseConfig.get('hostname')
domainname = baseConfig.get('domainname')
url = baseConfig.get('privacyidea/saml/url', 'https://%s.%s/privacyidea' % (hostname, domainname))
realm = baseConfig.get('privacyidea/saml/realm', '')
verifyhost = baseConfig.get('privacyidea/saml/verifyhost', 'True')
verifypeer = baseConfig.get('privacyidea/saml/verifypeer', 'True')
print """
$config['privacyidea'] = array(
                'privacyidea:privacyidea',
                'privacyideaserver' => '%s',"
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
