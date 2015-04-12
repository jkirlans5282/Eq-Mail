<?php

  require_once 'google-api-php-client-master/src/Google/autoload.php'; // or wherever autoload.php is located
  
  include_once("class.contextio.php");

  
  $client_id='995914534687-98tm5pj2p4fjjshavrtgku28b1q5o1rk.apps.googleusercontent.com';
  $client_secret='i33IWm94_Qz_UoofWeZOztop';
  $redirect_url='https://www.mail.google.com';
  
  $client = new Google_Client();
  $client->setClientSecret($client_secret);
  $client->setClientId($client_id);
  $client->setRedirectUri($redirect_uri);
  
  
  $serviceUrl = new Google_Service_Urlshortener($client);
  $client->addScope(Google_Service_Urlshortener::URLSHORTENER);
  
  
  $client->setApplicationName("HackCU");
  $client->setDeveloperKey("AIzaSyAb7M7pPz13KXkrjZmT99M7SaogC1aTVjs");

  
  $authUrl = $client->createAuthUrl();
  
  if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
}
$client->setRedirectUri($redirect_uri);

  $service = new Google_Service_Gmail($client);

  /**
 * Retrieve a List of Drafts.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @return Array of Drafts.
 */
 
// see https://console.context.io/#settings to get your consumer key and consumer secret.
$contextIO = new ContextIO('6bbaozd7','WucIFMnI5UkHfruB');
$accountName = null;
// list your accounts
$r = $contextIO->listAccounts();
foreach ($r->getData() as $account) {
	if (is_null($accountName)) {
		$accountName = $account['email_addresses'];
	}
}
if (is_null($accountName)) {
	die;
}

function listDrafts($service, $accountName) {
  $drafts = array();
echo "Hello World";
  try {
    $draftsResponse = $service->users_drafts->listUsersDrafts($accountName);
    if ($draftsResponse->getDrafts()) {
      $drafts = array_merge($drafts, $draftsResponse->getDrafts());
	  echo "Hello World";
    }
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }

  foreach ($drafts as $draft) {
    print 'Draft with ID: ' . $draft->getId() . '<br/>';
  }

  return $drafts;
}
listDrafts($service,$accountName);

?>