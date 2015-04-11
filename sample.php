#!/usr/bin/php
<?php
echo "hello world";
function contextio(){
// remove first line above if you're not running these examples through PHP CLI
include_once("class.contextio.php");
// see https://console.context.io/#settings to get your consumer key and consumer secret.
$contextIO = new ContextIO('6bbaozd7','WucIFMnI5UkHfruB');
$accountId = null;
// list your accounts
$r = $contextIO->listAccounts();
foreach ($r->getData() as $account) {
	echo $account['id'] . "\t" . join(", ", $account['email_addresses']) . "\n";
	if (is_null($accountId)) {
		$accountId = $account['id'];
	}
}
if (is_null($accountId)) {
	die;
}
// Get the most recent drafts message reciepient
$messageListResponseDrafts = $contextIO->listMessages($user['id'], array('label' => 0, 'folder' => $folder['[Gmail]/Drafts']));
$messagesDrafts = $messageListResponseDrafts->getData();
$messageRecent= $messagesDrafts[0];
$toEmail= $messageRecent->addresses->to[0]->email;

// EXAMPLE 1
// Print the subject line of the last 100 emails sent to with bill@widgets.com
$args = array('to'=>$toEmail, 'limit'=>100);
echo "\nGetting last 100 messages exchanged with {$args['to']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	echo "Subject: ".$message['subject']."\n";
}

// EXAMPLE 2
// Print the Data  of the last 100 emails sent to with bill@widgets.com
$args = array('to'=>$toEmail, 'limit'=>100);
echo "\nGetting last 100 messages exchanged with {$args['to']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	echo "Message: ".$message['bodies']."\n";
}

// EXAMPLE 3
// Download all versions of the last 2 attachments exchanged with bill@widgets.com
$saveToDir = dirname(__FILE__)."/".mt_rand(100,999);
mkdir($saveToDir);
$args = array('email'=>'bill@widgets.com', 'limit'=>2);
echo "\nObtaining list of last two attachments exchanged with {$args['email']}\n";
$r = $contextIO->listFiles($accountId, $args);
foreach ($r->getData() as $document) {
	echo "\nDownloading all versions of document \"".$document['file_name']."\"\n";
	foreach ($document['occurrences'] as $attachment) {
		echo "Downloading attachment '".$attachment['file_name']."' to $saveToDir ... ";
		$contextIO->getFileContent($accountId, array('file_id'=>$attachment['fileId']), $saveToDir."/".$attachment['file_name']);
		echo "done\n";
	}
}
// EXAMPLE 4
// Download all attachments with a file name that matches 'creenshot'
$saveToDir = dirname(__FILE__)."/".mt_rand(100,999);
mkdir($saveToDir);
echo "\nDownloading all attachments matching 'creenshot'\n";
$args = array('file_name'=>'creenshot');
$r = $contextIO->listFiles($accountId, $args);
foreach ($r->getData() as $attachment) {
	echo "Downloading attachment '".$attachment['file_name']."' to $saveToDir ... ";
	$contextIO->getFileContent($accountId, array('file_id'=>$attachment['file_id']), $saveToDir."/".$attachment['file_name']);
	echo "done\n";
}
echo "\nall examples finished\n";
<<<<<<< Updated upstream
=======
echo "hello world";
>>>>>>> Stashed changes
}


contextio();

$output = shell_exec("curl 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false' -H 'Authorization: Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==' -H 'Origin: chrome-extension://fdmmgilgnpjigdojojpjoooidkmcomcm' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' -H 'Content-Language: en' -H 'Accept: application/json' -H 'Cache-Control: no-cache' -H 'Cookie: Watson-DPAT=SjN4c0RUS2FnMHB0QWdhcDl5WUV5ejdFc2RSRDZBN0hVRjFTanAwenpCdTlZeHF3UmZrMzNzeEVodHV4a25pWGRlREtPVXZDZDZMODIydXNoc2lyZmNReDUwUmJpOFh6djNOTk54TVlYMXVxTTZlOE1kYitqNTNzVm1qbXJLOSt3SnhNczZMNmdWejVVNTRWNmhBZXRQM2R6MXVxUGs3MGJDbjZNaDJENXJRWTFOenp1KytSZms3bDc4ZStCVlFEcFpQQXVRWjNwbk1ETTA2d2tNNVBxUEJkN3VZdkYraDNoTjV4dUpyTm5IY3Y1V1RscFBqKzhaUFZ2UmZxQzh5dFpJeHRmdkJ6UEdwUGFRN0ViQ0xJeU1COG96SmJNbkY2VUdOWmVBVTdPTWdKZ3JFZUxVRDIzRTlFc3U4K2xwRW4yYmpES0p4ZmtiMUFDU0hVM2tHclhNb0hkakplaG0ycEpseG92VVo4bS9BPQ==' -H 'Connection: keep-alive' -H 'Content-Type: text/plain' --data-binary $'As a constituent, consumer, and tech user, I am deeply concerned about the provisions that are being written into the Trans-Pacific Partnership (TPP) and other trade agreements being negotiated by the Office of the United States Trade Representative. I oppose \u201ctrade\u201d policies that are developed without proper oversight or input from the public. The shear fact that wikileaks was the source to provide the full text of the bill should indicate that TPP outlines laws which are NOT in the best interests of the general public, since the laws had to be hidden from the public. TPP contains clauses which are unacceptable. These clauses will extend pharmaceutical drug patents, restrict internet freedoms, and create a legal framework for companies to sue nations over potential profit loss.f user created content which TPP seeks to destroy. For more information and arguments which are presented better then mine check out www.citizens.org and www.eff.org' --compressed");
echo(output);
?>