<?php
	session_start();
	
	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location: index.php');
		exit();
	}
	else{
		unset($_SESSION['udanarejestracja']);
	}
?>
<!DOCTYPE HTML>
<html lang='pl'>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv = "X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="stylelog.css" type="text/css"/>
	<link rel="shortcut icon" type="image/png" href="img/zombie-head.png" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=East+Sea+Dokdo&display=swap" rel="stylesheet">	
<title>zombiePHORIA - Log in</title>
</head>

<body>

	<div class="title">
		<img class="logo" src="img/zombie-head.png"> zombiePHORIA
	</div>
	
	<div class="subtitle">
		Death is not an escape
	</div>

	<div id="container">
		Thank you for registering an account on zombiePHORIA, you may now <a href="index.php" class = "log_in"> log in</a>.
	</div>

 	<div class="footer">
		Copyright © 2021 All rights reserved Kamil Woźniak, Wojciech Kołodziej
	</div>
</body>
</html>