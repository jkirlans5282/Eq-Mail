
<!DOCTYPE html>
<html>
<?php
include_once("class.contextio.php");
include_once("database.php")
define('CONSUMER_KEY', '6bbaozd7'); //prerits;
define('CONSUMER_SECRET', 'WucIFMnI5UkHfruB');

//define('CONSUMER_KEY', 'gvpktxy7'); //jacobs
//define('CONSUMER_SECRET', 'vqlZVUASfd0uIQ5U');

$logFile = fopen("logFile.txt", "a"); // logFile records and issues, or errors for debugging.

////  GET request is sent from chrome browser extension.
////  Can users signup and access our service without entering their api keys? -Jacob

if($_GET['email']!="")
{
	
	 
	//creates a connect token- Prerit 
	$addTokenResponse = $contextIO->addConnectToken(array('callback_url' => 'https://csel.cs.colorado.edu/~jaki2391/index.php', 'email' => '$_GET['email']')); 
	//get the redirect url from the response, and direct the user to it - Prerit
	$redirectUrl = $addTokenResponse->getDataProperty('browser_redirect_url');
	print_r($redirectUrl);
	//once the user connects, they will be redirected to the callback url with a contextio_token, which the app stores


	$contextIO = new ContextIO(CONSUMER_KEY, CONSUMER_SECRET); //declares an instance of the contextio class from the included php files.
	$accountId = null;

	// list your accounts
	$listOfAccounts = $contextIO->listAccounts(); // r is a list of email accounts? What is the return value if there are no accounts? -Jacob
	if($listOfAccounts==null) //check that there are valid accounts present. -Jacob
	{
		fwrite($logFile, "no valid accounts"); 
	}
	else
	{
		$fromEmail= $_GET['email'];
		// I don't like the static call, theres a possibility they sent 100 1 word emails. And also a possibility the sent 100 essays -Jacob
		// Is there a way it can return and quit once it has enough data to pass to watson? -Jacob
		// I don't quite understand what you mean by this. Do you want it to stop reading the email at a certain point? -Prerit
		$args = array('from'=>$fromEmail, 'limit'=>100, 'include_body'=>1); //Array of arguments passed to list messages call with context.io api -Jacob
		foreach ($listOfAccounts->getData() as $account) //getData() parses response into a php structure -Jacob 
		{												
			$accountId = $account['id']; //This assigns id to the current account -Jacob
			echo "\nGetting last 100 messages exchanged with {$args['from']}\n"; //Prints "Getting last 100 messages from (specified toEmail User)"
			$listOfMessages = $contextIO->listMessages($accountId, $args); //returns a list of messages sent to the user from fromEmail. -Jacob

			foreach ($listOfMessages->getData() as $message)
			{
				//I also don't like the nested loops too much data, its gonna slow down, and be a huge memory suck -Jacob
				//How else do you think we can improve from the nested for loops? -Prerit 
				$text .= $message['body'][0]['content']; //We need to check the size of the text object to ensure it doesnt exceed the max watson can handle, 2.2 mb? I think. -Jacob
				// Should we put a while loop here to ensure that it doesn't increase over 2.2 mb for IBM Watson? -Prerit 
			}
		}
	}
}
else{fwrite($logFile, "fromEmail is null, no email was passed in");}

$text = preg_replace("/[^A-Za-z0-9 ]/", '', $text); 
//Does the preg replace also eliminate semi colons and # ? -Jacob
$watsonString= "$'".$text."'";
///  this curl command is going to be a point of failure
///  Also susceptible to possible injection attack -Jacob
//////////////////////////////////////////////////////
$command = "curl 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false' -H 'Authorization: Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==' -H 'Origin: chrome-extension://fdmmgilgnpjigdojojpjoooidkmcomcm' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' -H 'Content-Language: en' -H 'Accept: application/json' -H 'Cache-Control: no-cache' -H 'Connection: keep-alive' -H 'Content-Type: text/plain' --data-binary ".$watsonString." --compressed";
$watsonOutput = exec($command);
//////////////////////////////////////////////////////

if(!$watsonOutput)
{
	fwrite($logFile, "Not enough data for watson: ".$text);
	throw new Exception('Not Enough data for Watson');
}
try 
{
	$watsonOutput = json_decode($watsonOutput, true);
	$traits = array
	( 
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
		"Trust"=>$watsonOutput['tree']['children'][0]['children'][0]['children'][3]['children'][5]['percentage'],
		"Cooperation"=>$watsonOutput['tree']['children'][0]['children'][0]['children'][3]['children'][1]['percentage'],
		"BUllshit"=>$watsonOutput['tree']['children'][0]['children'][0]['children'][3]['children'][1]['percentage'] //DO NOT REMOVE
	);
}
catch(Exception $e)
{
	$errorMessage = 'Caught Exception from watson: '.$e->getMessage(). '\n';
	fwrite($logFile, $errorMessage);
	$traits = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
}
foreach($traits as &$trait)
{
	$trait*=100;
	$trait = intval($trait);
}
$traitsColors = $traits; // this is redundent, we can simply alter traits directly in the next foreach -Jacob.

$lightRed='#E37D87';
$lightYellow='#EBD982';
$lightGreen='#62B274';
foreach($traitsColors as &$color)
{
	if ($color>=75) {
		$color = $lightGreen;
	}elseif($color>25){
		$color = $lightYellow;
	}else{
		$color = $lightRed;
	}
}

fclose($logFile);
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
		background-color: <?=$traitsColors['Self_Enhancement']?>;
	}
	#Excitement_Seeking{
		background-color: <?=$traitsColors['Excitement_Seeking']?>;
	}
	#Challenge{
		background-color: <?=$traitsColors['Challenge']?>;
	}
	#Practicality{
		background-color: <?=$traitsColors['Practicality']?>;
	}
	#Curiosity{
		background-color: <?=$traitsColors['Curiosity']?>;
	}
	#Structure{
		background-color: <?=$traitsColors['Structure']?>;
	}
	#Orderliness{
		background-color:<?=$traitsColors['Orderliness']?>;
	}
	#Intellect{
		background-color:<?=$traitsColors['Intellect']?>;
	}
	#Emotionality{
		background-color:<?=$traitsColors['Emotionality']?>;
	}
	#Openness_To_Change{
		background-color:<?=$traitsColors['Openness_To_Change']?>;
	}
	#Fiery{
		background-color: <?=$traitsColors['Fiery']?>;
	}
	#Susceptible_To_Stress{
		background-color: <?=$traitsColors['Susceptible_To_Stress']?>;
	}
	#Authority_Challenging{
		background-color: <?=$traitsColors['Authority_Challenging']?>;
	}
	#Cooperation{
		background-color: <?=$traitsColors['Cooperation']?>;
	}
	#Trust{
		background-color: <?=$traitsColors['Trust']?>;
		border-radius: 0 0 10px 10px;
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
		
		<h2 id ="Excitement_Seeking">
			<span style = "float: left">Excitement Seeking</span>
			<span style = "float: right"><?=$traits["Excitement_Seeking"]?>%</span>
		</h2>

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

	<h1>Approachability</h1>
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
			<span style = "float: left">Openness to change</span>
			<span style = "float: right"><?=$traits["Openness_To_Change"]?>%</span>
		</h2>
		<p>Emphasizes independent action, thought, and feeling, as well as a readiness for new experiences.</p>
		
	</div>

	<h1>Emotional traits</h1>
	<div>
		<h2 id ="Fiery">
			<span style = "float: left">Fiery</span>
			<span style = "float: right"><?=$traits["Fiery"]?>%</span>
		</h2>
		<p>Has a tendency to feel angry.</p>
		
		<h2 id = "Susceptible_To_Stress">
			<span style = "float: left">Susceptible to stress</span>
			<span style = "float: right"><?=$traits["Susceptible_To_Stress"]?>%</span>
		</h2>
		<p>Has difficulty coping with stress. They experience panic, confusion, and helplessness when under pressure.</p>
		
		<h2 id ="Authority_Challenging">
			<span style = "float: left">Authority Challenging</span>
			<span style = "float: right"><?=$traits["Authority_Challenging"]?>%</span>
		</h2>
		<p>Has a readiness to challenge authority, convention, and traditional values.</p>
		
		<h2 id = "Cooperation">
			<span style = "float: left">Cooperation</span>
			<span style = "float: right"><?=$traits["Cooperation"]?>%</span>
		</h2>
		
		<p>Dislikes confrontation. They are perfectly willing to compromise or to deny their own needs to get along with others.</p>
		
		<h2 id = "Trust">
			<span style = "float: left">Trust</span>
			<span style = "float: right"><?=$traits["Trust"]?>%</span>
		</h2>

		<p>Assumes that most people are fundamentally fair, honest, and have good intentions.</p>
		
	</div>
</aside>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

  <script src="js/index.js"></script>

</body>

</html>

