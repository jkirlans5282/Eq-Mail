<?php
// define your API key and secret - find this https://console.context.io/#settings

define('CONSUMER_KEY', '6bbaozd7');
define('CONSUMER_SECRET', 'WucIFMnI5UkHfruB');

function getContent() {

//create a connect token

$addTokenResponse = $contextIO->addConnectToken(array('callback_url' => 'http://gmail.com', 'email' => 'prerit.oberai@gmail.com'));

//get the redirect url from the response, and direct the user to it

$redirectUrl = $addTokenResponse->getDataProperty('browser_redirect_url');
print_r($redirectUrl);

//once the user connects, they will be redirected to the callback url with a contextio_token, which your app should store

//get a list of users, then pull the user ID for one you want to retrieve messages for
$userListResponse = $contextIO->listusers();
$users = $userListResponse->getData();
$user = $users[0];


//get most recent message from the drafts  folder
$messageListResponseDrafts = $contextIO->listMessages($user['id'], array('label' => 0, 'folder' => $folder['[Gmail]/Drafts']));
$messagesDrafts = $messageListResponseDrafts->getData();
$messageRecent= $messagesDrafts[0];
$toEmail= $messageRecent->addresses->to[0]->email;

//get list of messages from "ALL MAIL" folder
$messageListResponse = $contextIO->listMessages($user['id'], array('label' => 0, 'folder' => $folder['[Gmail]/All Mail']));
$messages = $messageListResponse->getData();

$messageResponse = $contextIO->getMessage($user['id'],
    array('label' => 0, 'folder' => $folder['[Gmail]/All Mail'], 'message_id' => $messages['email_message_id'], addresses->to[0]->email => $toEmail));

$counter=0;

$myFile = "BodyContent.txt";
$fh = fopen($myFile, 'w') or die("can't open file");

while($messageResponse)
{
	$messageBodyContent = ($messageResponse->bodies[$counter]->content);
	fwrite($fh, $messageBodyContent);H	
	$counter++;
}

fclose($fh);

echo "Hello world!";

}

getContent();

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS=> array(
    'Accept':'application/json',
    'Content-Type':'text/plain',
    'Accept-Language':'en',
    'Content-Language':"en',
    'Authorization':'Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw=='
    )
));
$result = curl_exec($curl);