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
	<link rel="stylesheet" href="stylemenu.css" type="text/css"/>
	<link rel="shortcut icon" type="image/png" href="img/zombie-head.png" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=East+Sea+Dokdo&display=swap" rel="stylesheet">
<title>zombiePHORIA - Account</title>
</head>

<body>
	
	<div class="title"> 
		<a href="menu.php"><img class="logo_small" src="img/zombie-head.png"> zombiePHORIA</a>
	</div>

	<div class="subtitle">
		Death is not an escape 
	</div>
	
	<div id="table">
		<table>
		  <tr>
			<th></th>
			<th>Sniper<br> <span style="font-size:16px;">Level: <?php echo $_SESSION['lvl_sniper'];?></span> </th>
			<th>Heavy<br> <span style="font-size:16px;"> Level: <?php echo $_SESSION['lvl_heavy'];?></span> </th>
			<th>Speedy<br> <span style="font-size:16px;"> Level: <?php echo $_SESSION['lvl_speedy'];?></span> </th>
		  </tr>
		  <tr>
			<td> Health&nbsp <img class="sprite_average" src="img/heart.png"></td>
			<td>60</td>
			<td>100</td>
			<td>40</td>
		  </tr>
		  <tr>	
			<td> Attack&nbsp <img class="sprite_average" src="img/sword.png"></td>
			<td>100</td>
			<td>60</td>
			<td>40</td>
		  </tr>
		  <tr>	
			<td> Rate of fire&nbsp <img class="sprite_average" src="img/fire.png"> </td>
			<td>20</td>
			<td>50</td>
			<td>100</td>
		  </tr>
		  <tr>	
			<td> Movement speed&nbsp <img class="sprite_average" src="img/boots.png"> </td>
			<td>50</td>
			<td>20</td>
			<td>90</td>
		  </tr>
		  <tr>	
			<td> Weapons </td>
			<td>&nbsp &nbsp<img class="sprite_big" src="img/glock.png"> &nbsp <img class="sprite_wide" src="img/sniper.png"></td>
			<td>&nbsp &nbsp<img class="sprite_big" src="img/glock.png"> &nbsp <img class="sprite_wide" src="img/minigun.png"></td>
			<td>&nbsp &nbsp<img class="sprite_big" src="img/glock.png"> &nbsp <img class="sprite_wide" src="img/smg.png"></td>
		  </tr>
		</table>
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
		<?php
			echo "<p> Welcome back ".$_SESSION['user']."! | ".$_SESSION['email']."</p>";
		?>
		<div class="textbox">
			<?php
				echo "Account level: ".$_SESSION['lvl']." (".$_SESSION['devotion_lvl'].")";
				
			?>
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
				This is a currency that you can spend in the shop. You get it by leveling your account, and the amount depends on the level you have.
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
