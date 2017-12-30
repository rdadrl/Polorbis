<?php
session_start();

header('Content-type:application/json;');
header('Charset: utf8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET'); 
header('Access-Control-Allow-Headers: X-Requested-With, content-type, X-Token, x-token');

require("../pop_conf.php"); //DB connection, version name etc.
$user = [];

if (isset($_SESSION['user-id']) && $_SESSION['user-id'] != "") {
	$statement = $db->prepare("select username, name, bio, exclass, class, level, hp, maxhp, xp from users where id = :id");
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	$statement->execute(array(':id' => $_SESSION['user-id']));
	$user = $statement->fetch();

	switch ($user["exclass"]) {
		case "mage":
			$user["exclass"] = "Ex-Mage";
			break;
		case "shadow":
			$user["exclass"] = "Ex-Shadow";
			break;
	}

	switch ($user["class"]) {
		case "healer":
			$user["class"] = "Medieval Healer";
			break;
		case "thief":
			$user["class"] = "Typical Thief";
			break;
	}

	echo json_encode($user);
}
else echo "Error: User session could not be found.";
?>