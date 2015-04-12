
<!DOCTYPE html>
<html>
<?php
//$red='#BC4A54';
$lightRed='#E37D87';
//$yellow='#C2AE4C';
$lightYellow='#EBD982';
//$green='#3A934D';
$lightGreen='#62B274';


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
echo($r);
foreach ($r->getData() as $message) {
	//print_r($message);
	//echo "Message: " .$message['body'][0]['content'];
	$text = $message['body'][0]['content'];
}
	
echo "\nall examples finished\n";

$text="Extending pharmaceutical patents beyond the current 20 the quick brown fox jumped over the lazy dog years will prevent generic drug production forcing patients to pay more for the same medication. This disincentives investment in research and development of new and better drugs, and at a time when drug companies already spend 1.5-2 times more on marketing, then on R&D, it is foolish to further desincentivize the advancement of life saving drugs. We need more effective drugs not more expensive ones. These high costs will also prevent the proliferation of these drugs in impoverished nations and locales where they are needed most."; //where text is the output of the context.io pull

$watsonString= "$'".$text."'";
$command = "curl 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false' -H 'Authorization: Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==' -H 'Origin: chrome-extension://fdmmgilgnpjigdojojpjoooidkmcomcm' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' -H 'Content-Language: en' -H 'Accept: application/json' -H 'Cache-Control: no-cache' -H 'Connection: keep-alive' -H 'Content-Type: text/plain' --data-binary ".$watsonString." --compressed";
//echo($command);
$watsonOutput = exec($command);
//$location = strpos ($output , '{');
//echo($output);
//echo("\n");
//echo($location."\n");
$watsonOutput = json_decode($watsonOutput, true);
//echo($watsonOutput['tree']['children']['id']);
echo("here");

?>

<head>

  <meta charset="UTF-8">

  <title>PHP</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <link href='http://fonts.googleapis.com/css?family=News+Cycle:400,700' rel='stylesheet' type='text/css'>
<link href="http://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
<style type="text/css">

	#Excitement_Seeking{
		background-color: <?=$lightGreen?>;
	}
	#Challenge{
		background-color: <?=$lightRed?>;
	}
	#Practicality{
		background-color: <?=$lightRed?>;
	}
	#Curiosity{
		background-color: <?=lightYellow?>;
	}
	#Structure{
		background-color: <?=$lightGreen?>;
	}
	#Orderliness{
		background-color: <?=$lightYellow?>
	}

</style>
<aside class="accordion">
	<h1>Motivation</h1>
	<div class="opened-for-codepen">
		<h2>Self enhancement</h2>
		<p>Seeks personal success for themselves.</p>
		
		<h2 id ="Excitement_Seeking">Excitement Seeking</h2>
		<p>Is easily bored without high levels of stimulation.</p>
		
		<h2 id="Challenge">Challenge</h2>
		<p>Has a readiness to challenge authority, convention, and traditional values.</p>
		
		<h2 id="Practicality">Practicality</h2>
		<p>Has a desire to get the job done and a desire for skill and efficiency.</p>
		
		<h2 id="Curiosity">Curiosity</h2>
		<p>Has a desire to discover, find out, and grow.</p>
		

	</div>

	<h1>Approchability</h1>
	<div>
		<h2 id = "Structure">Structure</h2>
		<p>They need things to be well organized and under control.</p>
		
		<h2 id = "Orderliness">Orderliness</h2>
		<p>Is well-organized, tidy, and neat.</p>
		
		<h2 id ="Intellect">Intellect</h2>
		<p>Is intellectually curious and tend to think in symbols and abstractions.</p>
		
		<h2 id = "Emotionality">Emotionality</h2>
		<p>Has good access to and awareness of their own feelings.</p>
		
		<h2 id = "Openness_To_Change">Openness To Change</h2>
		<p>Emphasizes independent action, thought, and feeling, as well as a readiness for new experiences.</p>
		
	</div>

	<h1>Emotional traits</h1>
	<div>
		<h2 id ="Fiery">Fiery</h2>
		<p>Has a tendency to feel angry.</p>
		
		<h2 id = "Susceptible_To_Stress">Susceptible To Stress</h2>
		<p>Has difficulty coping with stress. They experience panic, confusion, and helplessness when under pressure.</p>
		
		<h2 id ="Authority_Challenging">Authority Challenging</h2>
		<p>Has a readiness to challenge authority, convention, and traditional values.</p>
		
		<h2 id = "Cooperation">Cooperation</h2>
		<p>Dislikes confrontation. They are perfectly willing to compromise or to deny their own needs to get along with others.</p>
		
		<h2 id = "Trust">Trust</h2>
		<p>Assumes that most people are fundamentally fair, honest, and have good intentions.</p>
		
	</div>
</aside>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

  <script src="js/index.js"></script>

</body>

</html>

