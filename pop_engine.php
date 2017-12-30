<?php
session_start();

function checkUserSession(){ // a function which returns t/f according to simple user session check.
	if (isset($_SESSION['user-id']) && $_SESSION['user-id'] != "") return true;
	else return false;
}
function userLogOut(){ // a function which deletes the whole user session.
	session_destroy();
}
?>