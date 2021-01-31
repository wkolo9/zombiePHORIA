<?php
	session_start();
	
	if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in'] == true))
	{
		header('Location: menu.php');
		exit();
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

	<form action="logowanie.php" method="post">
	
		<input type="text" name ="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
		<input type="password" name ="password" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
		<br/><br>
	<?php
		if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
	
	?>
		<input type="submit" name="" value="Log me in">
		
	</form>
	<form action="rejestracja.php">
	
		<input type="submit" name="reg" value="Sign up">

	</form>
	
</div>

<div class="footer">
	Copyright © 2021 All rights reserved Kamil Woźniak, Wojciech Kołodziej
</div>

</body>
</html>