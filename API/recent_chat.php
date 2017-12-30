<?php
session_start();

header('Content-type:application/json;');
header('Charset: utf8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET'); 
header('Access-Control-Allow-Headers: X-Requested-With, content-type, X-Token, x-token');

require("../pop_conf.php"); //DB connection, version name etc.
$messages = [];
if (isset($_GET['timestamp']) && $_GET['timestamp'] != "") {
	$statement = $db->prepare("SELECT *
							FROM messages
							WHERE
							TIMESTAMP >= :tstamp
							AND
							TIMESTAMP >= NOW( ) - INTERVAL 10 MINUTE"); // User can retrieve msg's from last 10 minutes max from their last timestamp.
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	$statement->execute(array(':tstamp' => $_GET['timestamp']));

	$messages = []; //create messages array so even if no new messages were found an empty array is echo'ed ([])
	while($row = $statement->fetch()){
	    $selectUsr = $db->prepare("SELECT name FROM users WHERE id = :id");
		$selectUsr->setFetchMode(PDO::FETCH_ASSOC);
		$selectUsr->execute(array(':id' => $row["user_id"]));
		$selectUsr = $selectUsr->fetch();
		$msgobject = new stdClass(); //new msg as object

		$msgobject->message = $row['message'];
		$msgobject->name = $selectUsr['name'];
		$msgobject->timestamp = $row['timestamp'];
		$msgobject->id = $row['id'];
		
		array_push($messages, $msgobject); //push the new msg into the messages array
	}
}
else {
	$statement = $db->prepare("SELECT *
							FROM messages
							WHERE TIMESTAMP >= NOW( ) - INTERVAL :min 
							MINUTE");
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	$statement->execute(array(':min' => 1)); //select all msg's inside 1 minute span

	$messages = []; //create messages array so even if no new messages were found an empty array is echo'ed ([])
	while($row = $statement->fetch()){
	    $selectUsr = $db->prepare("SELECT name FROM users WHERE id = :id");
		$selectUsr->setFetchMode(PDO::FETCH_ASSOC);
		$selectUsr->execute(array(':id' => $row["user_id"]));
		$selectUsr = $selectUsr->fetch();
		$msgobject = new stdClass(); //new msg as object

		$msgobject->message = $row['message'];
		$msgobject->name = $selectUsr['name'];
		$msgobject->timestamp = $row['timestamp'];
		$msgobject->id = $row['id'];
		
		array_push($messages, $msgobject); //push the new msg into the messages array
	}

}

echo json_encode($messages);
?>
