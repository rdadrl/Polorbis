<?php

// POFP DEFINES
define("POP_VER", "Alpha 1.0.0");
// END POFP DEFINES
$SQL_dbname = "pop";
$SQL_user = "pop_master";
//$SQL_pass = ""; I wouldn't upload my password to the internet, would you?

try {
	$db = new PDO("mysql:host=localhost;dbname=" . $SQL_dbname . ";charset=utf8", $SQL_user, $SQL_pass);
}
catch ( PDOException $e ){
    print $e->getMessage();
}
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>