<?php
	session_start();
	
	require_once "db_connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	$id = $_SESSION['id'];
	
	if ($polaczenie->connect_errno != 0){
		echo "Error: ".$polaczenie->connect_errno;
	}
	else{
		$result = @$polaczenie->query("SELECT * FROM uzytkownicy WHERE id='$id'");
		$row = $result->fetch_assoc();
				$_SESSION['id'] = $row['id'];
				$_SESSION['lvl'] = $row['lvl'];
				$_SESSION['currency'] = $row['currency'];
				$_SESSION['lvl_glock'] = $row['lvl_glock'];
				$_SESSION['lvl_sniper'] = $row['lvl_sniper'];
				$_SESSION['lvl_awp'] = $row['lvl_awp'];
				$_SESSION['lvl_heavy'] = $row['lvl_heavy'];
				$_SESSION['lvl_minigun'] = $row['lvl_minigun'];
				$_SESSION['lvl_speedy'] = $row['lvl_speedy'];
				$_SESSION['lvl_smg'] = $row['lvl_smg'];
				$_SESSION['xp'] = $row['xp'];
				$_SESSION['devotion_lvl'] = $row['devotion_lvl'];
	}
	
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
	<link rel="stylesheet" href="stylemenu.css" type="text/css"/>
	<link rel="shortcut icon" type="image/png" href="img/zombie-head.png" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=East+Sea+Dokdo&display=swap" rel="stylesheet">
<title>zombiePHORIA - Menu</title>
</head>

<body>


	<div class="title">
		<img class="logo_small" src="img/zombie-head.png"> zombiePHORIA
	</div>

	<div class="subtitle">
		Death is not an escape 
	</div>
	
	<div class="buttons">
	  <div class="container">
		  <a href="choose_class.php" class="btn effectplay"><span>START THE GAME</span></a> 
		  <a href="shop.php" class="btn effect01"> <span>SHOP</span></a>
		  <a href="account.php" class="btn effect01"> <span>ACCOUNT</span></a>
		  <a href="how_to_play.php" class="btn effect01"> <span>HOW TO PLAY?</span></a>
		  <a href="credits.php" class="btn effect01"> <span>CREDITS</span></a>
	  </div>
	</div>

	<div id="menu">
		<?php echo "<p> Welcome back ".$_SESSION['user']."! | ".$_SESSION['email']."</p>"; ?>
		
		<div class="textbox">
			<?php echo "Account level: ".$_SESSION['lvl']." (".$_SESSION['devotion_lvl'].")"; ?>
			
			<p id="hover_text">
				<?php echo "Current xp: ".$_SESSION['xp']."/1000";?> <br> </br>
				This is your account level. The amount of xp you get at the end of the game depends on your score. The level resets after a 100. For each level reset you get 1 devotion level (the one in the brackets). Upon leveling up you get a bit of currency.
			</p>
		</div>
		
		<div class="textbox">
			<?php
				echo "Currency: ".$_SESSION['currency'];
			?>
			&nbsp <img class="sprite" src="img/currency.png"> 
			
			<p id="hover_text">
				This is a currency that you can spend in the shop. You can get it by leveling your account, and the amount depends on the level you have.
			</p>
			
		</div>
	</div>
	

		
	<div class="logout">
		<a href="logout.php" class="logout"> [Logout] </a> <br> </br>
	</div>
	
	<div class="footer">
		Copyright © 2021 All rights reserved Kamil Woźniak, Wojciech Kołodziej
	</div>
</body>
