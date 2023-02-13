<?php

try
{
    $stateId = SimpleSAML_Session::getSessionFromRequest()->getData("privacyidea:privacyidea", "stateId");
}
catch (Exception $e)
{
    SimpleSAML_Logger::error("Unable to reach the state ID from session. " . $e->getMessage());
    throw $e;
}
try
{
    SimpleSAML_Session::getSessionFromRequest()->deleteData("privacyidea:privacyidea", "stateId");
}
catch (Exception $e)
{
    SimpleSAML_Logger::error("Unable to delete the old state ID. " . $e->getMessage());
    throw $e;
}

try
{
    $state = SimpleSAML_Auth_State::loadState($stateId, 'privacyidea:privacyidea', true);
}
catch (SimpleSAML_Error_NoState $e)
{
    SimpleSAML_Logger::error("Lost state data. " . $e->getMessage());
    throw $e;
}
catch (Exception $e)
{
    SimpleSAML_Logger::error("Unable to load the state. " . $e->getMessage());
    throw $e;
}

// Find the username
if (array_key_exists('username', $_REQUEST))
{
    $username = (string)$_REQUEST['username'];
}
elseif (isset($state['privacyidea:privacyidea']['uidKey']))
{
    $uidKey = $state['privacyidea:privacyidea']['uidKey'];
    $username = $state['Attributes'][$uidKey][0];
}
elseif (isset($state['privacyidea:privacyidea']['username']))
{
    $username = $state['privacyidea:privacyidea']['username'];
}
elseif (isset($state['core:username']))
{
    $username = (string)$state['core:username'];
}
else
{
    $username = '';
}

$formParams = array(
    "username" => $username,
    "pass" => array_key_exists('password', $_REQUEST) ? $_REQUEST['password'] : "",
    "otp" => array_key_exists('otp', $_REQUEST) ? $_REQUEST['otp'] : "",
    "mode" => array_key_exists('mode', $_REQUEST) ? $_REQUEST['mode'] : "otp",
    "pushAvailable" => array_key_exists('pushAvailable', $_REQUEST) ? $_REQUEST['pushAvailable'] : "false",
    "otpAvailable" => array_key_exists('otpAvailable', $_REQUEST) ? $_REQUEST['otpAvailable'] : "true",
    "modeChanged" => array_key_exists('modeChanged', $_REQUEST) ? $_REQUEST['modeChanged'] : "false",
    "webAuthnSignResponse" => array_key_exists('webAuthnSignResponse', $_REQUEST) ? $_REQUEST['webAuthnSignResponse'] : "",
    "webAuthnSignRequest" => array_key_exists('webAuthnSignRequest', $_REQUEST) ? $_REQUEST['webAuthnSignRequest'] : "",
    "origin" => array_key_exists('origin', $_REQUEST) ? $_REQUEST['origin'] : "",
    "u2fSignRequest" => array_key_exists('u2fSignRequest', $_REQUEST) ? $_REQUEST['u2fSignRequest'] : "",
    "u2fSignResponse" => array_key_exists('u2fSignResponse', $_REQUEST) ? $_REQUEST['u2fSignResponse'] : "",
    "message" => array_key_exists('message', $_REQUEST) ? $_REQUEST['message'] : "",
    "imageOTP" => array_key_exists('imageOTP', $_REQUEST) ? $_REQUEST['imageOTP'] : "",
    "imagePush" => array_key_exists('imagePush', $_REQUEST) ? $_REQUEST['imagePush'] : "",
    "imageU2F" => array_key_exists('imageU2F', $_REQUEST) ? $_REQUEST['imageU2F'] : "",
    "imageWebauthn" => array_key_exists('imageWebauthn', $_REQUEST) ? $_REQUEST['imageWebauthn'] : "",
    "loadCounter" => array_key_exists('loadCounter', $_REQUEST) ? $_REQUEST['loadCounter'] : 1
);

if ($state['privacyidea:privacyidea']['authenticationMethod'] === "authprocess")
{
    // Auth Proc
    try
    {
        $response = sspmod_privacyidea_Auth_Utils::authenticatePI($state, $formParams);
        $stateId = SimpleSAML_Auth_State::saveState($state, 'privacyidea:privacyidea');

        // If the authentication is successful processPIResponse will not return!
        if (!empty($response))
        {
            $stateId = sspmod_privacyidea_Auth_Utils::processPIResponse($stateId, $response);
        }
        $url = SimpleSAML_Module::getModuleURL('privacyidea/FormBuilder.php');
        SimpleSAML_Utils_HTTP::redirectTrustedURL($url, array('stateId' => $stateId));
    }
    catch (Exception $e)
    {
        SimpleSAML_Logger::error($e->getMessage());
    }
}
else
{
    // Auth Source
    try
    {
        $source = SimpleSAML_Auth_Source::getById($state["privacyidea:privacyidea"]["AuthId"]);
    }
    catch (SimpleSAML_Error_Exception $e)
    {
        SimpleSAML_Logger::error("Unable to load the authsource. SimpleSAML Exception: " . $e->getMessage());
        throw $e;
    }

    if (method_exists($source, "getRememberUsernameEnabled") && $source->getRememberUsernameEnabled())
    {
        try
        {
            $sessionHandler = SimpleSAML_SessionHandler::getSessionHandler();
            $params = $sessionHandler->getCookieParams();
            $params['expire'] = time();
            $params['expire'] += (isset($_REQUEST['rememberUsername']) && $_REQUEST['rememberUsername'] === 'Yes' ? 31536000 : -300);
            try
            {
                SimpleSAML_Utils_HTTP::setCookie($source->getAuthId() . '-username', $username, $params, FALSE);
            }
            catch (SimpleSAML_Error_CannotSetCookie $e)
            {
                SimpleSAML_Logger::error("Unable to save the username in a cookie. " . $e->getMessage());
            }
        }
        catch (Exception $e)
        {
            SimpleSAML_Logger::error("Unable to reach the simpleSAML Session Handler. Cannot to save the username. " . $e->getMessage());
        }
    }

    if (method_exists($source, "isRememberMeEnabled") && $source->isRememberMeEnabled())
    {
        if (array_key_exists('rememberMe', $_REQUEST) && $_REQUEST['rememberMe'] === 'Yes')
        {
            $state['RememberMe'] = TRUE;
            $stateID = SimpleSAML_Auth_State::saveState($state, sspmod_core_Auth_UserPassBase::STAGEID);
        }
    }

    try
    {
        sspmod_privacyidea_Auth_Source_PrivacyideaAuthSource::authSourceLogin($stateID, $formParams);
    }
    catch (Exception $e)
    {
        SimpleSAML_Logger::error($e->getMessage());

        try
        {
            $state = SimpleSAML_Auth_State::loadState($stateID, 'privacyidea:privacyidea', true);
            $state['privacyidea:privacyidea']['errorCode'] = $e->getCode();
            $state['privacyidea:privacyidea']['errorMessage'] = $e->getMessage();
            $stateID = SimpleSAML_Auth_State::saveState($state, 'privacyidea:privacyidea');
        }
        catch (SimpleSAML_Error_NoState $e)
        {
            SimpleSAML_Logger::error($e->getMessage());
        }
        catch (Exception $e)
        {
            SimpleSAML_Logger::error($e->getMessage());
        }
    }
}
