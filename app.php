// define your API key and secret - find this https://console.context.io/#settings

define('CONSUMER_KEY', '6bbaozd7');
define('CONSUMER_SECRET', 'WucIFMnI5UkHfruB');

//create a connect token

$addTokenResponse = $contextIO->addConnectToken(array('callback_url' => 'http://yourcallback.com', 'email' => 'test@gmail.com'));

//get the redirect url from the response, and direct the user to it

$redirectUrl = $addTokenResponse->getDataProperty('browser_redirect_url');
print_r($redirectUrl);

//once the user connects, they will be redirected to the callback url with a contextio_token, which your app should store

//get a list of users, then pull the user ID for one you want to retrieve messages for
$userListResponse = $contextIO->listusers();
$users = $userListResponse->getData();
$user = $users[0];

//list folders for that user - 0 is an alias for the first email account of that user
$folderListResponse = $contextIO->listEmailAccountFolders($user['id'], '0');
print_r($folderListResponse);

//get list of messages from a folder
$messageListResponse = $contextIO->listMessages($user['id'], array('label' => 0, 'folder' => $folder['name']));
$messages = $messageListResponse->getData();
print_r($messages);

