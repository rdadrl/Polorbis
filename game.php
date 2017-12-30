<?php
session_start();
// start session control
if (isset($_SESSION['user-id']) && $_SESSION['user-id'] != "") {
	echo "<script>console.log('logged in as user-id: ' + " . $_SESSION['user-id'] . ");</script>";
}
else {
	header("Location: index.php?er=2");
}
//end session control
require("pop_conf.php"); //DB connection, version name etc.
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width">
		<title>People of Polorbis - <?=POP_VER;?></title>
		<meta name="description" content="A text-based MMORPG from epic fiction novel of Polorbis">
		<meta name="author" content="Arda NTOURALI">

		<link href="https://fonts.googleapis.com/css?family=Almendra+Display|Eagle+Lake|MedievalSharp" rel="stylesheet">
		<link rel="stylesheet" type="text/CSS" href="CSS/main.css">
		<link rel="stylesheet" type="text/CSS" href="CSS/font-awesome.css">

		<script src="progressbar.min.js"></script>
	</head>
	<body onkeydown="bodyKeyDown(this)">
		<div id="header" class="noselect">
			<div class="logo">
				<h1>People of Polorbis</h1>
			</div>
		</div>

		<div id="left-bar">
			<div id="character">
				<img class="picture" src="pp.png">
				<div class="info">
					<div id="name" class="usr"></div>
					Level <span id="level"></span> <span id="exclass"></span>, <span id="class"></span>
					<br>
					<i id="bio"></i>
				</div>
				<a class="settings" href="#" onclick="changePopupState(getElementById('profile-popup').parentNode);"><i class="fa fa-cog"></i></a>

				<div class="hptext">HP: <span id="hp">0/0</span> <i class="fa fa-heart"></i></div><div id="hpbar" class="pbar"></div>

				<ul style="margin: 0; margin-left: 15px; margin-top: 150px; color: white; list-style-type: none; padding: 0; ">
					<li><i class="fa fa-bolt"></i> STA: <span id="stamina">0</span></li>
					<li><i class="fa fa-hand-rock-o"></i> STR: <span id="strenght">0</span></li>
					<li><i class="fa fa-graduation-cap"></i> INT: <span id="intelligence">0</span></li>
					<li><i class="fa fa-magic"></i> DEX: <span id="dexterity">0</span></li>
					<li><i class="fa fa-eye-slash"></i> PERCEPTION: <span id="perception">0</span></li>
				</ol>
			</div>

			<div id="info-bar">
				<br>
				<form action="index.php"><button>Change Character</button></form> <form method="post" action="index.php"><button name="logout-button">Logout</button></form>
				<br>
				<button>Forums</button>
				<br>
				<button>Polorbis Novel</button>	<button>Polorbis Wiki</button>
				<br>
				<button>Leaderboard</button> <button onclick="changePopupState(getElementById('donate-popup').parentNode)">Donate Us</button>
				<br>
				<button>F.A.Q.</button>
			</div>
		</div>

		<div id="right-bar">

		<div id="tabs">
		  <button class="tablink active" tab-index="0" onclick="changeTab(this, 'Map')">Map</button>
		  <button class="tablink" tab-index="1" onclick="changeTab(this, 'Equipment')">Equipment</button>
		  <button class="tablink" tab-index="2" onclick="changeTab(this, 'Inventory')">Inventory</button>
		</div>

		<div id="Map" class="tab" style="display: block;"><h1>Place a map here.</h1></div>
		<div id="Equipment" class="tab"><h1>This tab will let user see his equipment and their status. Renaming-forging-levelling up and enchanting will be made under this tab.</h1></div>
		<div id="Inventory" class="tab"><h1>User will be able to see his whole inventory under this tab.</h1></div>

			<div id="chat">
				<div class="channel">
					<h1 class="white-t-shadow">Channel List</h1>
					<button>Public Channel</button>
					<button>Guild Channel</button>
					<button>Dankest Dank</button>
					<button>Public Channel</button>
					<button>Guild Channel</button>
					<button>Dankest Dank</button>
					<button>Public Channel</button>
					<button>Guild Channel</button>
					<button>Dankest Dank</button>
				</div>
				<!--Start Messages -->
				<div id="chat-container" class="container">
				</div>
			</div>
			<div id="chat-enter">
				<input type="text" onkeydown="checkChatEntry(this)" placeholder="[Public Channel] Enter to chat" autocomplete="off">
			</div>
		</div>

		<div id="popup-container" class="popup-selector" style="display: none;">
			<div id="profile-popup" class="popup">
				<a href="#" onclick="changePopupState(this.parentNode.parentNode)"><i class="fa fa-close"></i></a>
				<h2 class="white-t-shadow">Settings</h2>
				<div class="name">
					<input type="text" id="setname" placeholder="Change your visible name"><input type="submit" value="Set Name">
				</div>
				<div class="pp">
					<img src="pp.png" class="picture">
					<div class="description">
						Change your profile picture
					</div>
				</div>
				<div class="bio">
					<textarea id="setbio" placeholder="Input your characters biography."></textarea>
				</div>
			</div>
		</div>

		<div id="popup-container" class="popup-selector" style="display: none;">
			<div class="popup">
				<a href="#" onclick="changePopupState(this.parentNode.parentNode)"><i class="fa fa-close"></i></a>
			</div>
		</div>

		<div id="popup-container" class="popup-selector" style="display: none;">
			<div id="donate-popup" class="popup">
				<a href="#" onclick="changePopupState(this.parentNode.parentNode)"><i class="fa fa-close"></i></a>
				<h2 class="white-t-shadow">Donate Us</h2>

				<p>Donating us helps us fund our server maintenance, buy better server gear and have more time for updates.
					<br>
					<small>
					As PoP is a work of hobby, we try our bests to keep up with the user base. With the growing amount of users, we constantly need to upgrade our server specifications, which in return rises the costs.
					<br>
					</small>
					PoP creators and moderators thanking you for your helps, wishes you have greatest fun!
				</p>
				<div style="text-align: center;">Donate <button>via Paypal</button><button>via Skrill (CC)</button></div>
			</div>
		</div>

		<!-- embeds -->
		<embed src="sounds/msg_received.wav" autostart="false" width="0" height="0" id="msg_received" enablejavascript="true">

		<script src="https://code.jquery.com/jquery-3.2.1.min.js"   integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
		<script>
			$.ajaxSetup({
			    async: false
			});
			var player = { //player object
				username: "Username",
				name: "Name",
				level: 1,
				class: "Class",
				exclass: "Ex-Class",
				bio: "Biography",
				maxhp: 1,
				hp: 1,
				xp: 0,
				stamina: 1,
				dexterity: 1,
				intelligence: 1,
				strenght: 1,
				perception: 1,
				charisma: 1

			}

			function updateCharacter() {
				$.getJSON("/PoP/API/fetch_character.php")
				  	.done(function( data ) {
				    	if (data == "Error: User session could not be found.") {
				    		console.log(data);
				    	}
				    	else {
				    		player.username = data.username;
				    		player.name = data.name;
				    		player.bio = data.bio;
				    		player.exclass = data.exclass;
				    		player.class = data.class;
				    		player.level = data.level;
				    		player.hp = data.hp;
				    		player.maxhp = data.maxhp;
				    		player.xp = data.xp;

				    		$("#name").html(player.name);
							$("#level").html(player.level);
							$("#class").html(player.class);
							$("#exclass").html(player.exclass);
							$("#bio").html(player.bio);
							$("#hp").html(player.hp + "/" + player.maxhp);
							$("#setname").attr("placeholder", "Change your visible name (" + player.name + ")");

							if (player.bio != "") $("#setbio").attr("placeholder", player.bio);
							else $("#setbio").attr("placeholder", "Input your characters biography.");
				    	}
				  	})
				  	.fail(function( jqxhr, textStatus, error ) {
				    	var err = textStatus + ", " + error;
				    	console.log( "Request Failed: " + err );
				});

				$("#name").html(player.name);
				$("#level").html(player.level);
				$("#class").html(player.class);
				$("#exclass").html(player.exclass);
				$("#bio").html(player.bio);
				$("#hp").html(player.hp + "/" + player.maxhp);
				$("#setname").attr("placeholder", "Change your visible name (" + player.name + ")");

				if (player.bio != "") $("#setbio").attr("placeholder", player.bio);
				else $("#setbio").attr("placeholder", "Input your characters biography.");
			}
			function updateStats(){
				$("#stamina").html(player.stamina);
				$("#strenght").html(player.strenght);
				$("#intelligence").html(player.intelligence);
				$("#dexterity").html(player.dexterity);
				$("#perception").html(player.perception);
			}

			var snd_msg_received = new Audio('sounds/msg_received.mp3');

			function addChatEntry(msg, method) {
				chat = document.getElementById("chat-container");

				if (method.method != "usr") {
					chat.insertAdjacentHTML( 'beforeend', "<span class='line " + method.method + "'>&nbsp;[" + method.method.toUpperCase() + "] &gt;&nbsp;" + msg + "</span>");
				}
				else if (method.method == "usr") {
					chat.insertAdjacentHTML('beforeend', '<span class="line cht"> <i class="usr">' + method.user + '</i>&nbsp;&gt;&nbsp;' + msg + '</span>')
				}

				chat.scrollTop = chat.scrollHeight;
			}
			function sendChatMessage(msg) {
	            $.ajax({
	                url: '/PoP/API/send_chat.php',
	                dataType: 'text',
	                type: 'post',
	                contentType: 'application/x-www-form-urlencoded',
	                data: { 'messageText': msg },
	                success: function( data, textStatus, jQxhr ){
	                    console.log(data);
	                    if (data == "Success") addChatEntry(msg, {method:"usr", user: player.name});
	                    else {
	                    	console.log("Error sending message, error message: " + data);
	                    	if (data == "Error: User session could not be found.") {
	                    		console.log("Error: User session missing!");
	                    		addChatEntry("Your message, '" + msg.substring(0,12) + "...', was unable to sent due user session was invalid/not found. Please log-in again. <a href='#' onclick='sendChatMessage(\""+msg+"\")'>retry?</a>", {method:"sys"});
	                    	}
	                    	else if (data == "Error: User's message was longer than maximum lenght (255 char).") {
	                    		addChatEntry("Your message, '" + msg.substring(0,12) + "...', was unable to sent due message being longer than 256 characters.", {method:"sys"});       		
	                    	}
	                    	else if (data == "Error: User session was found but user's message was empty.") {
	                    		addChatEntry("Your message was unable to sent because message was empty.", {method:"sys"});       		
	                    	}
	                    	else if (data == "Error: Message could not be added into messages DB."){
	                    		addChatEntry("Your message was unable to sent due a problem in PoP Servers. Check server status from <a href='https://durali.net/PoP/status.php'>this link</a>. <a href='#' onclick='sendChatMessage(\""+msg+"\")'>retry?</a>", {method:"sys"});
	                    	}
	                    	else addChatEntry("Your message, '" + msg.substring(0,12) + "...', was unable to sent. (<i>" + data + "</i>) <a href='#' onclick='sendChatMessage(\""+msg+"\")'>retry?</a>", {method:"sys"});
	                    }
	                },
	                error: function( jqXhr, textStatus, errorThrown ){
	                    console.log( errorThrown );
	                    addChatEntry(
	                    	"Your message, '" + msg + "', was unable to sent. <a style='color: red;' href='#' onclick='sendChatMessage(\""+msg+"\")'>retry?</a>", {method:"sys"});
	                }
	            });
			}
			var local_messages = [];
			function retrieveRecentChat(){
				var tstamp;
				if (local_messages.length == 0) tstamp = "";
				else tstamp = local_messages[local_messages.length - 1]["timestamp"];
				$.getJSON('/PoP/API/recent_chat.php', { timestamp: tstamp }, function(data) {
					if (local_messages.length == 0 && data.length != 0) {
						console.log("First chat check detected.");
						local_messages = data;
						for (var i = 0; i < local_messages.length; i++) {
							if (local_messages[i]["name"] != player.name) addChatEntry(local_messages[i]["message"], {method: "usr", user: local_messages[i]["name"]});
						}
						snd_msg_received.play();
					}
					else if (local_messages.length == 0 && data.length == 0) {
						console.log("Although first chat check was detected, because the nearby messages were null, we have discarded this data request.");
					}
					else if (local_messages[local_messages.length - 1]["id"] == data[data.length - 1]["id"]) {
						console.log("No new messages found.");
						return true;
					}
					else {
						var newmsgcount = data[data.length - 1]["id"] - local_messages[local_messages.length - 1]["id"];
						console.log("Supposedly, there are new " + newmsgcount + " messages.");
						for (var i = 0; i < newmsgcount; i++) {
							var newmsg = data.filter(function(msg){
								return msg["id"] == parseInt(local_messages[local_messages.length - 1]["id"]) + i + 1;
							})[0];
							local_messages.push(newmsg);
							if (newmsg["name"] != player.name) addChatEntry(newmsg["message"], {method:"usr", user: newmsg["name"]});
						}
						snd_msg_received.play();
					}
				}); 
			}
			function checkChatEntry(ele) {
				if (event.key === "Enter" && ele.value != "") {
					sendChatMessage(ele.value);
					ele.value = "";
				}
			}
			function changeChatInterval(ele) {
				clearInterval(chatCheck);
				if (ele.value = "Manual") console.log("Chat check has been stopped, waiting users manual refresh.");
				else {
					chatCheck = setInterval(retrieveRecentChat, ele.value);
					console.log("Chat Check has been updated to " + ele.value + "ms interval.");
				}
			}
			function changeTab(ele, tabname) {
			    var i, tabcontent, tab;

			    tab = document.getElementsByClassName("tab");
			    for (i = 0; i < tab.length; i++) {
			        tab[i].style.display = "none";
			    }

			    tablink = document.getElementsByClassName("tablink");
			    for (i = 0; i < tablink.length; i++) {
			        tablink[i].className = tablink[i].className.replace(" active", "");
			    }

			    document.getElementById(tabname).style.display = "block";
			    ele.className += " active";
			    /*if (evt != "") evt.currentTarget.className += " active";
			    else console.log($("#tabs > button:contains('" + tabname + "')"));*/

			}

			//Popup & Change Tab checker
			function bodyKeyDown(ele) {
				if (event.key === "Escape" && isPopupPresent()) {
					popups = document.getElementsByClassName("popup");
					for (i = 0; i < popups.length; i++) {
						if (popups[i].parentNode.style.display === "block") changePopupState(popups[i].parentNode);
					}
				}
				
				/* Tab Controller */
				if (event.key === "Tab" && !isPopupPresent()) {
					event.preventDefault();
					var currentTab = $("#tabs > .active")[0];
					var nextTab = $("button[tab-index='" + ((parseInt(currentTab.getAttribute("tab-index")) + 1) % 3) + "']"	);
					nextTab.click();
				}
				else if (event.key === "Tab") event.preventDefault();
			}

			function isPopupPresent() {
				console.log($('.popup-selector').filter(function() {
				    return $(this).css('display') == 'block';
				}));
				if ($('.popup-selector').filter(function() {
				    return $(this).css('display') == 'block';
				}).length > 0) return true;
				else return false;
			}
			function changePopupState(elem){
				if (elem.style.display == "block") elem.style.display = "none";
				else elem.style.display = "block";
			}
			//end popup checker

			// game state below
			var bar = new ProgressBar.Line(document.getElementById("hpbar"), {
			  strokeWidth: 4,
			  easing: 'easeInOut',
			  duration: 800,
			  color: '#FFEA82',
			  trailColor: '#eee',
			  trailWidth: 1,
			  svgStyle: {width: '100%', height: '100%'},
			  from: {color: '#FFEA82'},
			  to: {color: '#ED6A5A'},
			  step: (state, bar) => {
			    bar.path.setAttribute('stroke', state.color);
			  }
			});

			var chatCheck;

			function init() {
				console.log("PoP Client is Initializing");
				console.log("%c WARNING ! This is the Javascript (the programming language client is programmed in) console!\nPasting or Writing any code in this console might let hackers get in control of your account.\nPoP Administrators and moderators are unable to help you in a such situation. You are warned!", "color: white; background: red; font-family: monospace;");

				//update character
				updateCharacter();
				updateStats();

				//animate bar
				bar.animate(player.hp / player.maxhp);  // Number from 0.0 to 1.0
				console.log("Animated health bar to position: %" + player.hp / player.maxhp * 100);

				//welcome message
				addChatEntry("Welcome, <span style='color: gold;'>" + player.name + " <i>[" + player.username + "]</i></span>, to PoP.", {method: "sys"});
				chatCheck = setInterval(retrieveRecentChat, 500);
			}
			init();
		</script>
	</body>
</html>