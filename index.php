
<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>PHP</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <link href='http://fonts.googleapis.com/css?family=News+Cycle:400,700' rel='stylesheet' type='text/css'>
<link href="http://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
<style type="text/css">
	#Structure{
		background-color: <?=$black?>;
	}
</style>
<aside class="accordion">
	<h1>Motivation</h1>
	<div class="opened-for-codepen">
		<h2>Self enhancement</h2>
		<p>Seeks personal success for themselves.</p>
		
		<h2>Excitement-Seeking</h2>
		<p>Is easily bored without high levels of stimulation.</p>
		
		<h2>Challenge</h2>
		<p>Has a readiness to challenge authority, convention, and traditional values.</p>
		
		<h2>Practicality</h2>
		<p>Has a desire to get the job done and a desire for skill and efficiency.</p>
		
		<h2>Curiosity</h2>
		<p>Has a desire to discover, find out, and grow.</p>
		

	</div>

	<h1>Approchability</h1>
	<div>
		<h2 id = "Structure" >Structure</h2>
		<p>They need things to be well organized and under control.<\p>
		
		<h2>Orderliness</h2>
		<p>Is well-organized, tidy, and neat.<\p>
		
		<h2>Intellect</h2>
		<p>Is intellectually curious and tend to think in symbols and abstractions.<\p>
		
		<h2>Emotionality</h2>
		<p>Has good access to and awareness of their own feelings.<\p>
		
		<h2>Openness To Change</h2>
		<p>Emphasizes independent action, thought, and feeling, as well as a readiness for new experiences.<\p>
		
	</div>

	<h1>Emotional traits</h1>
	<div>
		<h2>Fiery</h2>
		<p>Has a tendency to feel angry.<\p>
		
		<h2>Susceptible to stress</h2>
		<p>Has difficulty coping with stress. They experience panic, confusion, and helplessness when under pressure.<\p>
		
		<h2>Authority Challenging</h2>
		<p>Has a readiness to challenge authority, convention, and traditional values.<\p>
		
		<h2>Cooperation</h2>
		<p>Dislikes confrontation. They are perfectly willing to compromise or to deny their own needs to get along with others.<\p>
		
		<h2>Trust</h2>
		<p>Assumes that most people are fundamentally fair, honest, and have good intentions.<\p>
		
	</div>
</aside>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

  <script src="js/index.js"></script>

</body>

</html>

<?php
//header("Content-type:text/css");
$black='#000';

// remove first line above if you're not running these examples through PHP CLI
include_once("class.contextio.php");
// see https://console.context.io/#settings to get your consumer key and consumer secret.
$contextIO = new ContextIO('6bbaozd7','WucIFMnI5UkHfruB');
$accountId = null;

// list your accounts
$r = $contextIO->listAccounts();
foreach ($r->getData() as $account) {
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
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	echo "Subject: ".$message['subject']."\n";
}

// EXAMPLE 2
// Print the Data  of the last 100 emails sent from with bill@widgets.com

$args = array('from'=>$toEmail, 'limit'=>100, 'include_body'=>1);
//echo "\nGetting last 100 messages exchanged with {$args['from']}\n";
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	//print_r($message);
	//echo "Message: " .$message['body'][0]['content'];
	$text = $message['body'][0]['content'];
}
	
fclose($fh);


echo "\nall examples finished\n";

$text=""; //where text is the output of the context.io pull

$watsonString= "$'".$text."'";
$command = "curl 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false' -H 'Authorization: Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==' -H 'Origin: chrome-extension://fdmmgilgnpjigdojojpjoooidkmcomcm' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' -H 'Content-Language: en' -H 'Accept: application/json' -H 'Cache-Control: no-cache' -H 'Connection: keep-alive' -H 'Content-Type: text/plain' --data-binary ".$watsonString." --compressed";
//echo($command);
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
