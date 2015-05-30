<?php
$logFile = fopen("watsonLogFile.txt", "a"); // logFile records and issues, or errors for debugging.
function getProfileFromText($emailContent){
	$emailContent = preg_replace("/[^A-Za-z0-9 ]/", '', $emailContent); 
	//Does the preg replace also eliminate semi colons and # ? -Jacob
	$watsonString= "$'".$emailContent."'";
	$traits = array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1);

	///  this curl command is going to be a point of failure
	///  Also susceptible to possible injection attack -Jacob
	//////////////////////////////////////////////////////
	$command = "curl 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false' -H 'Authorization: Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==' -H 'Origin: chrome-extension://fdmmgilgnpjigdojojpjoooidkmcomcm' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' -H 'Content-Language: en' -H 'Accept: application/json' -H 'Cache-Control: no-cache' -H 'Connection: keep-alive' -H 'Content-Type: text/plain' --data-binary ".$watsonString." --compressed";
	$watsonOutput = exec($command);
	if(!$watsonOutput)
	{
		fwrite($logFile, "Not enough data for watson: ".$emailContent);
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
			"Time Created"=>time() //DO NOT REMOVE
		);
	}
	catch(Exception $e)
	{
		$errorMessage = 'Caught Exception from watson: '.$e->getMessage(). '\n';
		fwrite($logFile, $errorMessage);
	}
	foreach($traits as &$trait)
	{
		$trait*=100;
		$trait = intval($trait);
	}
	return $traits;
}

?>
