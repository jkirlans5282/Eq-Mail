
<?php
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
		echo $accountId;
	}
}
if (is_null($accountId)) {
	die;
}
// Get the most recent drafts message reciepient
/*$messageListResponseDrafts = $contextIO->listMessages($user['id'], array('label' => 0, 'folder' => $folder['[Gmail]/Drafts']));
$messagesDrafts = $messageListResponseDrafts->getData();
$messageRecent= $messagesDrafts[0];
*/
$toEmail= 'jacobkirlanstout@gmail.com';  // $messageRecent->addresses->to[0]->email;

// EXAMPLE 1
// Print the subject line of the last 100 emails sent to with bill@widgets.com
$args = array('from'=>'jacobkirlanstout@gmail.com', 'limit'=>100);
echo "\nGetting last 100 messages exchanged with {$args['to']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	echo "Subject: ".$message['subject']."\n";
}

// EXAMPLE 2
// Print the Data  of the last 100 emails sent to with bill@widgets.com

$myFile = "BodyContent.txt";
$fh = fopen($myFile, 'w') or die("can't open file");

$args = array('to'=>$toEmail, 'limit'=>100);
echo "\nGetting last 100 messages exchanged with {$args['to']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	echo "Message: " .$message->bodies[$r]->content;
	$messageBodyContent = $message->bodies[$counter]->content;
	fwrite($fh, $messageBodyContent);
}
	
fclose($fh);

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

?>