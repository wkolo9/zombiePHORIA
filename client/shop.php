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
<title>zombiePHORIA - Shop</title>

	
</head>

<body>


	<div class="title">
		 <a href="menu.php"><img class="logo_small" src="img/zombie-head.png"> zombiePHORIA</a>
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
	<div class="shop">
		<div class="shop_box">
			<img class="sprite_big" src="img/glock.png">
			
			<p id="shop_lvl"> Level <?php echo $_SESSION['lvl_glock'] ?>/10 </p>
			<p id="shop_textbox"> Attack Damage: 45<?php echo '<span style="color: Chartreuse"> + '.floor((1/2*$_SESSION['lvl_glock'])).' ('.floor((45+(1/2*$_SESSION['lvl_glock']))).')</span>'?> </p>
			<p id="shop_textbox"> Max Ammo: 240<?php echo '<span style="color: Chartreuse"> + '.(6*$_SESSION['lvl_glock']).' ('.(240+(6*$_SESSION['lvl_glock'])).')</span>'?> </p>
			<p id="shop_textbox"> Starting Ammo: 100<?php echo '<span style="color: Chartreuse"> + '.(3*$_SESSION['lvl_glock']).' ('.(100+(3*$_SESSION['lvl_glock'])).')</span>'?> </p>
			<p id="shop_textbox"> Clip Size: 10<?php echo '<span style="color: Chartreuse"> + '.(1*$_SESSION['lvl_glock']).' ('.(10+(1*$_SESSION['lvl_glock'])).')</span>'?> </p>
			<form action="upgradeglock.php">
				<input type="submit" id="glock" value="Upgrade">
				<br>
				<?php 
					if($_SESSION['insufficient_glock'] == 1){
						echo '<div class="error"> Insufficient currency </div>';
						$_SESSION['insufficient_glock'] =  0;
					}
					if($_SESSION['max_glock'] == 1){
						echo '<div class="error"> This weapon is already at max lvl </div>';
						$_SESSION['max_glock'] =  0;
					}
				?>
				
			</form>
			
				<?php 
				if ($_SESSION['lvl_glock'] < 10)
				{
					if(($_SESSION['currency'] > ($_SESSION['lvl_glock'] + 1) * 200) || ($_SESSION['currency'] == ($_SESSION['lvl_glock'] + 1) * 200)){
						echo '<div class="cost_yes"> Cost: '.(($_SESSION['lvl_glock'] + 1) * 200).'  <img class="sprite" src="img/currency.png"></div>';
					}
					else
					{
						echo '<div class="cost_no"> Cost: '.(($_SESSION['lvl_glock'] + 1) * 200).'  <img class="sprite" src="img/currency.png"></div>';
					}
				}
				?>
		</div>
		
		<div class="shop_box">
			<img class="sprite_wide" src="img/sniper.png">
			
			<p id="shop_lvl"> Level <?php echo $_SESSION['lvl_awp'] ?>/10 </p>
			<p id="shop_textbox"> Attack Damage: 100<?php echo '<span style="color: Chartreuse"> + '.(2*$_SESSION['lvl_awp']).' ('.(100+(2*$_SESSION['lvl_awp'])).')</span>'?> </p>
			<p id="shop_textbox"> Max Ammo: 25<?php echo '<span style="color: Chartreuse"> + '.(2*$_SESSION['lvl_awp']).' ('.(25+(2*$_SESSION['lvl_awp'])).')</span>'?> </p>
			<p id="shop_textbox"> Starting Ammo: 5<?php echo '<span style="color: Chartreuse"> + '.(1*$_SESSION['lvl_awp']).' ('.(5+(1*$_SESSION['lvl_awp'])).')</span>'?> </p>
			<p id="shop_textbox"> Clip Size: 5<?php echo '<span style="color: Chartreuse"> + '.floor((1/2*$_SESSION['lvl_awp'])).' ('.floor((5+(1/2*$_SESSION['lvl_awp']))).')</span>'?> </p>
			<form action="upgradeawp.php">
				<input type="submit" id="awp" value="Upgrade">
				<br>
				<?php 
					if($_SESSION['insufficient_awp'] == 1){
						echo '<div class="error"> Insufficient currency </div>';
						$_SESSION['insufficient_awp'] = 0;
					}
					if($_SESSION['max_awp'] == 1){
						echo '<div class="error"> This weapon is already at max lvl </div>';
						$_SESSION['max_awp'] =  0;
					}					
				?>
			</form>
				<?php 
				if ($_SESSION['lvl_awp'] < 10)
				{
					if(($_SESSION['currency'] > ($_SESSION['lvl_awp'] + 1) * 200) || ($_SESSION['currency'] == ($_SESSION['lvl_awp'] + 1) * 200)){
						echo '<div class="cost_yes"> Cost: '.(($_SESSION['lvl_awp'] + 1) * 200).'  <img class="sprite" src="img/currency.png"></div>';
					}
					else
					{
						echo '<div class="cost_no"> Cost: '.(($_SESSION['lvl_awp'] + 1) * 200).'  <img class="sprite" src="img/currency.png"></div>';
					}
				}
				?>			
		</div>
		
		<div class="shop_box">
			<img class="sprite_wide" src="img/minigun.png">
			
			<p id="shop_lvl"> Level <?php echo $_SESSION['lvl_minigun'] ?>/10 </p>
			<p id="shop_textbox"> Attack Damage: 60<?php echo '<span style="color: Chartreuse"> + '.($_SESSION['lvl_minigun']).' ('.(60+$_SESSION['lvl_minigun']).')</span>'?> </p>
			<p id="shop_textbox"> Max Ammo: 300<?php echo '<span style="color: Chartreuse"> + '.(10*$_SESSION['lvl_minigun']).' ('.(300+(10*$_SESSION['lvl_minigun'])).')</span>'?> </p>
			<p id="shop_textbox"> Starting Ammo: 100<?php echo '<span style="color: Chartreuse"> + '.(10*$_SESSION['lvl_minigun']).' ('.(100+(10*$_SESSION['lvl_minigun'])).')</span>'?> </p>
			<p id="shop_textbox"> Clip Size: 100<?php echo '<span style="color: Chartreuse"> + '.(5*$_SESSION['lvl_minigun']).' ('.(100+(5*$_SESSION['lvl_minigun'])).')</span>'?> </p>
			<form action="upgrademinigun.php">
				<input type="submit" id="minigun" value="Upgrade">
				<br>
				<?php 
					if($_SESSION['insufficient_minigun'] == 1){
						echo '<div class="error"> Insufficient currency </div>';
						$_SESSION['insufficient_minigun'] = 0;
					}
					if($_SESSION['max_minigun'] == 1){
						echo '<div class="error"> This weapon is already at max lvl </div>';
						$_SESSION['max_minigun'] =  0;
					}
				?>
			</form>
				<?php 
				if ($_SESSION['lvl_minigun'] < 10)
				{
					if(($_SESSION['currency'] > ($_SESSION['lvl_minigun'] + 1) * 200) || ($_SESSION['currency'] == ($_SESSION['lvl_minigun'] + 1) * 200)){
						echo '<div class="cost_yes"> Cost: '.(($_SESSION['lvl_minigun'] + 1) * 200).'  <img class="sprite" src="img/currency.png"></div>';
					}
					else
					{
						echo '<div class="cost_no"> Cost: '.(($_SESSION['lvl_minigun'] + 1) * 200).'  <img class="sprite" src="img/currency.png"></div>';
					}
				}
				?>			
		</div>
		
		<div class="shop_box">
			<img class="sprite_wide" src="img/smg.png">
			
			<p id="shop_lvl"> Level <?php echo $_SESSION['lvl_smg'] ?>/10 </p>
			<p id="shop_textbox"> Attack Damage: 40<?php echo '<span style="color: Chartreuse"> + '.($_SESSION['lvl_smg']).' ('.(40+$_SESSION['lvl_smg']).')</span>'?> </p>
			<p id="shop_textbox"> Max Ammo: 120<?php echo '<span style="color: Chartreuse"> + '.(8*$_SESSION['lvl_smg']).' ('.(120+(8*$_SESSION['lvl_smg'])).')</span>'?> </p>
			<p id="shop_textbox"> Starting Ammo: 48<?php echo '<span style="color: Chartreuse"> + '.(3*$_SESSION['lvl_smg']).' ('.(24+(3*$_SESSION['lvl_smg'])).')</span>'?> </p>
			<p id="shop_textbox"> Clip Size: 24<?php echo '<span style="color: Chartreuse"> + '.$_SESSION['lvl_smg'].' ('.(24+$_SESSION['lvl_smg']).')</span>'?> </p>
			<form action="upgradesmg.php">
				<input type="submit" id="smg" value="Upgrade">
				<br>
				<?php 
					if($_SESSION['insufficient_smg'] == 1){
						echo '<div class="error"> Insufficient currency </div>';
						$_SESSION['insufficient_smg'] = 0;
					}
					if($_SESSION['max_smg'] == 1){
						echo '<div class="error"> This weapon is already at max lvl </div>';
						$_SESSION['max_smg'] =  0;
					}
				?>
			</form>
				<?php 
				if ($_SESSION['lvl_smg'] < 10)
				{
					if(($_SESSION['currency'] > ($_SESSION['lvl_smg'] + 1) * 200) || ($_SESSION['currency'] == ($_SESSION['lvl_smg'] + 1) * 200)){
						echo '<div class="cost_yes"> Cost: '.(($_SESSION['lvl_smg'] + 1) * 200).'  <img class="sprite" src="img/currency.png"></div>';
					}
					else
					{
						echo '<div class="cost_no"> Cost: '.(($_SESSION['lvl_smg'] + 1) * 200).'  <img class="sprite" src="img/currency.png"></div>';
					}
				}
				?>			
		</div>	
	</div>

		
	<div class="logout">
		<a href="logout.php" class="logout"> [Logout] </a> <br> </br>
	</div>
	
	<div class="footer">
		Copyright © 2021 All rights reserved Kamil Woźniak, Wojciech Kołodziej
	</div>
</body>
