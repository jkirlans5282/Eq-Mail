<?php
include_once("class.contextio.php");

class database{
	protected $db;
	function __construct()
	{
		try{
			$db = new SQLite3('myDatabase.sqlite', 0666, $error); 	//creates Sqlite3 database
			$db->exec('CREATE TABLE Users '.'(Id TEXT, Email TEXT)'; 
			$db->exec('CREATE TABLE Profiles'.'(QueryID TEXT, ProfileEmail TEXT, Profile TEXT )');
			print('database initialized.');

		}catch(Exception $e){
			print($error); //prints error from line 8 -Jacob

			//add logging.
		}
	}
	public function addPersonalityProfileForEmail($contextIoID,$email,$profile){
		$db->exec('INSERT INTO Profiles ()');
	}
	public function getPersonalityProfile($contextIoID,$email){
		return profile;
	}
}
$database = new database();
?>