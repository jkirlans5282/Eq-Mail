<?php

$text="";

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
/*$toEmail='';
// Get the most recent drafts message reciepient
$draftsArgs = array('folder'=>'Drafts', 'limit'=>100);
$s = $contextIO->listMessages($accountId, $draftsArgs);
foreach ($s->getData() as $messageDraft) {
	echo "toEmail: ".$messageDraft['to']."\n";
	$toEmail=$messageDraft['to'];
}
  // $messageRecent->addresses->to[0]->email;
*/

$toEmail= 'jacobkirlanstout@gmail.com';
// Print the subject line of the last 100 emails sent from with bill@widgets.com
$args = array('from'=>$toEmail, 'limit'=>100);
echo "\nGetting last 100 messages exchanged with {$args['from']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	echo "Subject: ".$message['subject']."\n";
}

// EXAMPLE 2
// Print the Data  of the last 100 emails sent from with bill@widgets.com

$args = array('from'=>$toEmail, 'limit'=>100, 'include_body'=>1);
echo "\nGetting last 100 messages exchanged with {$args['from']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	print_r($message);
	echo "Message: " .$message['body'][0]['content'];
	$text = $message['body'][0]['content'];
}


echo "\nall examples finished\n";


$watsonString= "$'".$text."'";
$command = "curl 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false' -H 'Authorization: Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==' -H 'Origin: chrome-extension://fdmmgilgnpjigdojojpjoooidkmcomcm' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' -H 'Content-Language: en' -H 'Accept: application/json' -H 'Cache-Control: no-cache' -H 'Connection: keep-alive' -H 'Content-Type: text/plain' --data-binary ".$watsonString." --compressed";
echo($command);
$watsonOutput = exec($command);
//$location = strpos ($output , '{');
//echo($output);
//echo("\n");
//echo($location."\n");
var_dump(json_decode($watsonOutput));


#top 5 traits as number 0-100
$colorOne=90;
$colorTwo=80;
$colorThree=70;
$colorFour=60;
$colorFive=50;

$colors = array(
$colorOne,
$colorTwo,
$colorThree,
$colorFour,
$colorFive,
);
foreach($colors as &$color){
	if($color>70){
		$color="#00FF00";
	}else if($color>50){
		$color="#0000FF";
	}
	else{
		$color = "#FF0000";
	}
}
//echo("#one:{color:".$colors[0]);
//echo("#two:{color:".$colors[1]);
//echo("#three:{color:".$color[2]);
//echo("#four:{color:".$color[3]);
//echo("#five:{color:".$color[4]);


?>
<HTML>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Hello, world!</h1>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <table style="width:100%">
    <tr id="one"><td> item </td><td> value </td></tr>
    <tr id="two"><td> item </td><td> value </td></tr>
    <tr id="three"><td> item </td><td> value </td></tr>
    <tr id="four"><td> item </td><td> value </td></tr>
    <tr id="five"><td> item </td><td> value </td></tr>
    <tr id="six"><td> item </td><td> value</td></tr>
    </table>
  </body>







</HTML>