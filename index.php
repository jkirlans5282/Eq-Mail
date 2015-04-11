#!/usr/bin/php

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
$args = array('from'=>$toEmail, 'limit'=>100);
echo "\nGetting last 100 messages exchanged with {$args['from']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	echo "Subject: ".$message['subject']."\n";
}

// EXAMPLE 2
// Print the Data  of the last 100 emails sent to with bill@widgets.com

$myFile = "BodyContent.txt";
$fh = fopen($myFile, 'w') or die("can't open file");

$args = array('to'=>$toEmail, 'limit'=>100, 'include_body'=>1);
echo "\nGetting last 100 messages exchanged with {$args['to']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	echo "Message: " .$message['body'][0]['content'];
	//$messageBodyContent = $message->bodies[$counter]->content;
	//fwrite($fh, $messageBodyContent);
}
	
fclose($fh);


echo "\nall examples finished\n";

$text="written into the Trans-Pacific Partnership (TPP) and other trade agreements being negotiated by the Office of the United States Trade Representative. I oppose “trade” policies that are developed without proper oversight or input from the public. The shear fact that wikileaks was the source to provide the full text of the bill should indicate that TPP outlines laws which are NOT in the best interests of the general public, since the laws had to be hidden from the public. TPP contains clauses which are unacceptable. These clauses will extend pharmaceutical drug patents, restrict internet freedoms, and create a legal framework for companies to sue nations over potential profit loss.
Extending pharmaceutical patents beyond the current 20 years will prevent generic drug production forcing patients to pay more for the same medication. This disincentives investment in research and development of new and better drugs, and at a time when drug companies already spend 1.5-2 times more on marketing, the"; //where text is the output of the context.io pull

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