
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
$toEmail='';
// Get the most recent drafts message reciepient

$toEmail= 'jacobkirlanstout@gmail.com';
// Print the subject line of the last 100 emails sent from with bill@widgets.com
$args = array('from'=>$toEmail, 'limit'=>100);
$r = $contextIO->listMessages($accountId, $args);
foreach ($r->getData() as $message) {
	//echo "Subject: ".$message['subject']."\n";
}

// EXAMPLE 2
// Print the Data  of the last 100 emails sent from with bill@widgets.com

$args = array('from'=>$toEmail, 'limit'=>100, 'include_body'=>1);
//echo "\nGetting last 100 messages exchanged with {$args['from']}\n";
$r = $contextIO->listMessages($accountId, $args);
//echo($r);
foreach ($r->getData() as $message) {
	//echo "Message: " .$message['body'][0]['content'];
	$text .= $message['body'][0]['content'];
}
	
echo "\nall examples finished\n";

$text = preg_replace("/[^A-Za-z0-9 ]/", '', $text);
$watsonString= "$'".$text."'";
$command = "curl 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false' -H 'Authorization: Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==' -H 'Origin: chrome-extension://fdmmgilgnpjigdojojpjoooidkmcomcm' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' -H 'Content-Language: en' -H 'Accept: application/json' -H 'Cache-Control: no-cache' -H 'Connection: keep-alive' -H 'Content-Type: text/plain' --data-binary ".$watsonString." --compressed";
$watsonOutput = exec($command);
$watsonOutput = json_decode($watsonOutput, true);
$traits = array(
				"Self_Enhancement" => $watsonOutput['tree']['children'][2]['children'][0]['children'][3]['percentage'], //self-enhancement
				"Excitement_Seeking" => $watsonOutput['tree']['children'][0]['children'][0]['children'][2]['children'][3]['percentage'], //excitement seeking
				"Challenge" => $watsonOutput['tree']['children'][1]['children'][0]['children'][0]['percentage'],
				"Practicality" => $watsonOutput['tree']['children'][1]['children'][0]['children'][8]['percentage'],
				"Curiosity" => $watsonOutput['tree']['children'][1]['children'][0]['children'][2]['percentage'],
				"Structure" => $watsonOutput['tree']['children'][1]['children'][0]['children'][11]['percentage'],
				"Orderliness" => $watsonOutput['tree']['children'][0]['children'][0]['children'][1]['children'][3]['percentage'],
				"Intellect" => $watsonOutput['tree']['children'][0]['children'][0]['children'][0]['children'][4]['percentage'],
				"Emotionality" => $watsonOutput['tree']['children'][0]['children'][0]['children'][0]['children'][2]['percentage'],
				"Openness_To_Change" => $watsonOutput['tree']['children'][2]['children'][0]['children'][1]['percentage'],
				"Fiery" => $watsonOutput['tree']['children'][0]['children'][0]['children'][4]['children'][0]['percentage'],
				"Susceptible_To_Stress" => $watsonOutput['tree']['children'][0]['children'][0]['children'][4]['children'][5]['percentage'],
				"Authority_Challenging" => $watsonOutput['tree']['children'][0]['children'][0]['children'][0]['children'][5]['percentage'],
				"Cooperation"=>$watsonOutput['tree']['children'][0]['children'][0]['children'][3]['children'][1]['percentage'],
				"Trust"=>$watsonOutput['tree']['children'][0]['children'][0]['children'][3]['children'][5]['percentage']
				);
foreach($traits as &$trait){
	$trait*=100;
	$trait = intval($trait);
	echo("\n");
	echo($trait);
}


// Print the subject line of the last 100 emails sent TO contact
$args2 = array('to'=>$toEmail, 'limit'=>100);
$r2 = $contextIO->listMessages($accountId, $args2);
foreach ($r2->getData() as $messageSent) {
	//echo "Subject[Reply]: ".$messageSent['subject']."\n";
}

// Print the Data  of the last 100 emails sent TO 

$args2 = array('to'=>$toEmail, 'limit'=>100, 'include_body'=>1);
//echo "\nGetting last 100 messages exchanged with {$args['to']}\n";
$r2 = $contextIO->listMessages($accountId, $args2);
foreach ($r2->getData() as $messageSent) {
	//echo "Message Sent Back: " .$messageSent['body'][0]['content'];
	$textTo .= $messageSent['body'][0]['content'];
}

 
?>

<head>

  <meta charset="UTF-8">

  <title>PHP</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <link href='https://fonts.googleapis.com/css?family=News+Cycle:400,700' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
<style type="text/css">
	#Self_Enhancement{

	}
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
		<h2 id = "Self_Enhancement">
			<span style = "float: left">Self Enhancement</span>
			<span style = "float: right"><?=$traits["Self_Enhancement"]?>%</span>
		</h2>
		<p>Seeks personal success for themselves.</p>
		
		<h2 id ="Excitement_Seeking">Excitement Seeking</h2>
		<p>Is easily bored without high levels of stimulation.</p>
		
		<h2 id="Challenge">
			<span style = "float: left">Challenge</span>
			<span style = "float: right"><?=$traits["Challenge"]?>%</span>
		</h2>
		<p>Has a readiness to challenge authority, convention, and traditional values.</p>
		
		<h2 id="Practicality">
			<span style = "float: left">Practicality</span>
			<span style = "float: right"><?=$traits["Practicality"]?>%</span>
		</h2>
		<p>Has a desire to get the job done and a desire for skill and efficiency.</p>
		
		<h2 id="Curiosity">
			<span style = "float: left">Curiosity</span>
			<span style = "float: right"><?=$traits["Curiosity"]?>%</span>
		</h2>
		<p>Has a desire to discover, find out, and grow.</p>
		

	</div>

	<h1>Approchability</h1>
	<div>
		<h2 id = "Structure">
			<span style = "float: left">Structure</span>
			<span style = "float: right"><?=$traits["Structure"]?>%</span>
		</h2>
		<p>They need things to be well organized and under control.</p>
		
		<h2 id = "Orderliness">
			<span style = "float: left">Orderliness</span>
			<span style = "float: right"><?=$traits["Orderliness"]?>%</span>
		</h2>
		<p>Is well-organized, tidy, and neat.</p>
		
		<h2 id ="Intellect">
			<span style = "float: left">Intellect</span>
			<span style = "float: right"><?=$traits["Intellect"]?>%</span>
		</h2>
		<p>Is intellectually curious and tend to think in symbols and abstractions.</p>
		
		<h2 id = "Emotionality">
			<span style = "float: left">Emotionality</span>
			<span style = "float: right"><?=$traits["Emotionality"]?>%</span>
		</h2>
		<p>Has good access to and awareness of their own feelings.</p>
		
		<h2 id = "Openness_To_Change">
			<span style = "float: left">Openness_To_Change</span>
			<span style = "float: right"><?=$traits["Openness_To_Change"]?>%</span>
		</h2>
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

