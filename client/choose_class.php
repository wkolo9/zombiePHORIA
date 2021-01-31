<?php
	session_start();
	
	if (!isset($_SESSION['logged_in']))
	{
		header('Location: index.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang='pl'>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv = "X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="styleplay.css" type="text/css"/>
	<link rel="shortcut icon" type="image/png" href="img/zombie-head.png" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=East+Sea+Dokdo&display=swap" rel="stylesheet">
<title>zombiePHORIA - Game</title>
</head>

<body>


	<div class="title">
		<a href="menu.php"><img class="logo" src="img/zombie-head.png"> zombiePHORIA</a>
	</div>

	<div class="subtitle">
		Choose your class! 
	</div>
	<!-- -->
	<div class="container">
	
		<form action="send_chosen_class.php" method="POST">
			<button type="submit" id="sniper" name="sniper" value="sniper" title="Sniper!"></button>
			<button type="submit" id="heavy" name="heavy" value="heavy" title="Heavy!"></button>
			<button type="submit" id="speedy" name="speedy" value="speedy" title="Speedy!"></button>
		</form>
		<!--
		<form action="http://localhost:2000/">
		</form>
		<input type="image" src="img/sniper_class.png" placeholder="sniper">
		<input type="image" src="img/heavy_class.png" placeholder="heavy">
		<input type="image" src="img/speedy_class.png" placeholder="speedy">
		-->
	</div>
	
	<div class="footer">
		Copyright © 2021 All rights reserved Kamil Woźniak, Wojciech Kołodziej
	</div>
</body>
