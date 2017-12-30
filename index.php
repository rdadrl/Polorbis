<?php
/* 
	List of the error codes for the index page:
	|Error Code|                        Summary                        |
		 1     | Invalid username/password combination
		 2	   | game.php Redirect due invalid session user_id or null
*/
session_start();
require("pop_conf.php"); //DB connection, version name etc.
require("pop_engine.php"); //Simplfy basic tasks, PoP engine!

if (isset($_POST['login-button'])) { //if user submitted login data
	$username = strtolower($_POST['username']);
	$password = hash('sha256', $_POST['password']);

	$statement = $db->prepare("SELECT id, username, COUNT(*) as count FROM users WHERE username = :un AND password = :pw");
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	$statement->execute(array(':un' => $username, ':pw' => $password));

	while ($row = $statement->fetch()) {
	  	$username_count = $row["count"];
	  	$user_id = $row['id'];
	  	$user_name = $row['username'];
	}
	if ($username_count == 1) {
		$_SESSION['user-id'] = $user_id;
	  	$_SESSION['user-name'] = $user_name;
	}
}

if (isset($_POST['logout-button'])) {
	userLogOut();
	header("Location: index.php");
}
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width">
		<title>People of Polorbis - Play Now!</title>
		<meta name="description" content="A text-based MMORPG from epic fiction novel of Polorbis">
		<meta name="author" content="Arda NTOURALI">

		<link href="https://fonts.googleapis.com/css?family=Almendra+Display|Eagle+Lake|MedievalSharp" rel="stylesheet">
		<link rel="stylesheet" type="text/CSS" href="CSS/main.css">
		<link rel="stylesheet" type="text/CSS" href="CSS/font-awesome.css">

		<!-- Pace Resources -->
		<link rel="stylesheet" type="text/CSS" href="CSS/pace.css">
		<script src="pace.min.js"></script>
		<!--End Pace Resources -->
	</head>
	<body>
		<div id="header" class="noselect">
			<div class="logo">
				<h1>People of Polorbis</h1>
			</div>
		</div>

		<div id="i_container">
			<div class="login-bar">
<?php
if (checkUserSession()) {
//sadly HEREDOC cannot have indentation. But also the only beautiful way to echo stuff.
$username = $_SESSION['user-name'];
echo <<<LoggedIn
<h2>Welcome <span class="usr">$username</span>!</h2>
<h3>Your Characters</h3>
<div class="character">aasmorth</div>
<form method="post" action="game.php">
	<button class="play">Play Now!</button>
</form>
<form method="post">
	<button class="logout" name="logout-button">Log Out</button>
</form>
LoggedIn;
}
else {
echo <<<LoggedOut
<h1>Login</h1>
LoggedOut;

if (isset($_GET['er'])) {
	if ($_GET['er'] == 1) {
		echo "<p class='er'>Username doesn't exists or wrong combination.<br><span class='sys'>Tip: Password is CaSeSenSiTive!</p>";
	}
}

if (isset($_GET['er'])) {
	if ($_GET['er'] == 2) {
		echo "<p class='er'>You have to login first in order to start playing PoP.</p>";
	}
}

echo <<<LoggedOut
<form method="POST">
	<input type="text" placeholder="Username" name="username"><br>
	<input type="password" placeholder="password" name="password">
	<input type="submit" name="login-button" value="Login">
</form>
LoggedOut;
}
?>
			</div>
		</div>
	</body>
</html>



