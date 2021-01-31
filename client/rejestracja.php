<?php
	session_start();
	if(isset($_POST['email'])){
		//flaga ktora sie zmieni na false jezeli cokolwiek bedzie niepoprawne przy walidacji
		$wszystko_OK = true;
		
		//sprawdzamy poprawnosc nicku
		$nick = $_POST['nick'];
		if ((strlen($nick) < 3) || (strlen($nick) > 20)){
			$wszystko_OK = false;
			$_SESSION['e_nick'] = "Nickname must be from 3 to 20 characters";
		}
		
		if(ctype_alnum($nick) == false){
			$wszystko_OK = false;
			$_SESSION['e_nick'] = "Nickname must consist only of letters and numbers";
		}
		
		//poprawnosc loginu
		$login = $_POST['login'];
		if ((strlen($login) < 3) || (strlen($login) > 20)){
			$wszystko_OK = false;
			$_SESSION['e_login'] = "Login must be from 3 to 20 characters";
		}
		
		if(ctype_alnum($login) == false){
			$wszystko_OK = false;
			$_SESSION['e_login'] = "Login must consist only of letters and numbers";
		}
		//poprawnosc maila
		$email = $_POST['email'];
		$emailB = filter_var ($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)){
			$wszystko_OK = false;
			$_SESSION ['e_email'] = "Incorrect email";
		}
		
		//poprawnosc hasla
		$haslo1 = $_POST['password1'];
		$haslo2 = $_POST['password2'];
		
		if ((strlen($haslo1) < 8) || (strlen($login) > 20)){
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = "Password must be from 8 to 20 characters";
		}
		
		if($haslo1 != $haslo2){
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = "Passwords must be identical";
		}
		

		//akcpetacja regulaminu
		if(!isset($_POST['regulamin'])){
			$wszystko_OK = false;
			$_SESSION['e_regulamin'] = "You must agree to the TOS";
		}
		
		//captcha
		$sekret = "6LdYER4aAAAAAFgWQkRPNb71rWS29BTGiFF9x6T4";
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if($odpowiedz->success == false){
			$wszystko_OK = false;
			$_SESSION['e_bot'] = "Prove you're not a robot!";
		}
		
		require_once "db_connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try{
			$polaczenie = new mysqli ($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}
			else{
				//czy email juz jest w bazie
				$rezultat = $polaczenie->query ("SELECT id FROM uzytkownicy WHERE email='$email'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili > 0){
					$wszystko_OK = false;
					$_SESSION['e_email'] = "There's an account already bound to that email";
				}
				//czy nick juz jest w bazie
				$rezultat = $polaczenie->query ("SELECT id FROM uzytkownicy WHERE user='$nick'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow > 0){
					$wszystko_OK = false;
					$_SESSION['e_nick'] = "There's an account with that same nickname";
				}
				
				//czy login juz jest w bazie
				$rezultat = $polaczenie->query ("SELECT id FROM uzytkownicy WHERE login='$login'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_loginow = $rezultat->num_rows;
				if($ile_takich_loginow > 0){
					$wszystko_OK = false;
					$_SESSION['e_login'] = "There's an account with that same login";
				}
						
				if($wszystko_OK == true){
					//gituwa
					if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$login', '$haslo1', '$email', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")){
						$_SESSION['udanarejestracja'] = true;
						header ('Location: welcome.php');
					}
					else{
						throw new Exception($polaczenie->error);
					}
				}
				
				$polaczenie->close();
			}
		}
		catch(Exception $e){
			echo '<span style="color:red;">Server error! Sorry for the inconvenience and please try again later</span>';
			echo '<br/> <span style="color:white;">do debuggowania: '.$e.'</span>';
		}

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
	<script src="https://www.google.com/recaptcha/api.js"></script>
<title>zombiePHORIA - Registration</title>
</head>

<body>
<div class="title_reg">
	<a href="index.php"><!--<img class="logo_reg" src="img/zombie-head.png">--> zombiePHORIA - registration</a>
</div>
	<div id="container_reg">
	<form method="post">
		Nickname: <br/> <input type="text" name="nick"/> <br/>
		<?php
			if (isset($_SESSION['e_nick'])){
				echo'<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?>
		Login: <br/> <input type="text" name="login"/> <br/>
		<?php
			if (isset($_SESSION['e_login'])){
				echo'<div class="error">'.$_SESSION['e_login'].'</div>';
				unset($_SESSION['e_login']);
			}
		?>
		E-mail: <br/> <input type="text" name="email"/> <br/>
		<?php
			if (isset($_SESSION['e_email'])){
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		Password: <br/> <input type="password" name="password1"/> <br/>
		<?php
			if (isset($_SESSION['e_haslo'])){
				echo'<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>
		Repeat password: <br/> <input type="password" name="password2"/> <br/>
		<br/>
		
		<label>
			<input type = "checkbox" name = "regulamin"/> Accept <a href="tos.html"  target="_blank">Terms of Service </a>
			<br></br>
		</label>
		
		<?php
			if (isset($_SESSION['e_regulamin'])){
				echo'<div class="error">'.$_SESSION['e_regulamin'].'</div>';
				unset($_SESSION['e_regulamin']);
			}
		?>
		
		<div class="g-recaptcha" 
			data-sitekey = "6LdYER4aAAAAAJQU4tF3rsOIGyzHB3c65FJDp6lI" >
        </div>
		
		<?php
			if (isset($_SESSION['e_bot'])){
				echo'<div class="error">'.$_SESSION['e_bot'].'</div>';
				unset($_SESSION['e_bot']);
			}
		?>
		
		<input type="submit" value="Register now!"/>
	</form>
	</div>
<!--
	<div class="footer">
		Copyright © 2021 All rights reserved Kamil Woźniak, Wojciech Kołodziej
	</div>
-->
</body>
</html>