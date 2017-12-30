<?php
session_start();
require("../pop_conf.php"); //DB connection, version name etc.

if (isset($_SESSION['user-id']) && $_SESSION['user-id'] != "") {
	if (isset($_POST['messageText']) && $_POST['messageText'] != "") {
		if (strlen($_POST['messageText']) < 256) {
			$msg = strip_tags($_POST['messageText']);
			$msg = htmlentities($msg);

			$statement = $db->prepare("INSERT INTO messages(user_id, message)
			   							 VALUES(:userid, :message)");
			if ($statement->execute(array(
			    "userid" => $_SESSION['user-id'],
			    "message" => $msg
			))) echo "Success";
			else echo "Error: Message could not be added into messages DB.";
		}
		else {
			echo "Error: User's message was longer than maximum lenght (255 char).";
		}
	}
	else {
		echo "Error: User session was found but user's message was empty.";
	}
}
else {
	//header();
	echo "Error: User session could not be found.";
}
?>