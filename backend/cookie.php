<?php
$logFile = fopen("cookieLogFile.txt", "a");
$cookie_name = "EQ-Mail Cookie";
$cookie_value; //json-array. Decode when grabbed, encode when modified.

function checkForCookie(){
	if(!isset($_COOKIE[$cookie_name])){
		try{
			setcookie($cookie_name, $cookie_value, 2147483647); //google 2038 bug for more info. essentiallly max value. 
		}catch(Exception $e){
			fwrite($logFile,"cookies disabled, or something like that, line 9 cookie.php");
		}
	}
}

function addProfile($email, $profileArray){
	if(!getProfile($email))
	{
		$tempArray = array($email=>$profileArray); // makes a multidemensional array where email points to profile dictionary
		$cookie_value = unserialize($_COOKIE[$cookie_name]); //returns dictionary.
		$cookie_value = array_merge($tempArray, $cookie_value);	//merge arrays
		$cookie_value = serialize($cookie_value); // serialize array into string for cookie set. 
		setcookie($cookie_name, $cookie_value, 2147483647);
		$_COOKIE[$cookie_name];
	}else{
		fwrite("user already exists");
	}
	///////Max cookie size if 4048 bytes we need to add error handling to ensure array never exceeeds this size, for now I'm just checking the size vlaue -Jacob
	$size = 0;
	if (function_exists('mb_strlen')) {
    	$size = mb_strlen($serializedFoo, '8bit');
	} else {
    	$size = strlen($serializedFoo);
	}
	fwrite($logFile, $size);
	////////////////////////////////////////////////////////////
}

//returns null if profile does not exist.
function getProfile($email){
	if(isset($_COOKIE[$cookie_name])){
		$profile =unserialize($_COOKIE[$cookie_name]); //I think this will work, if theres something wrong with the return value or it never returns anything its probably this line -Jacob
		if($profile){
			return $profile[$email];
		}else{
			fwrite($logFile, "profile for ". $email." not found line 46 cookie.php");
			return null;
		} 
	}else{
		fwrite($logFile, "Unable to find cookie line 44 cookie.php");
	}
}
?>