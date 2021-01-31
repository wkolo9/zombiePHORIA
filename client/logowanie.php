<?php
	session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['password']))){
		
		header('Location: index.php');
		exit();
	}
	
	require_once "db_connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno != 0){
		echo "Error: ".$polaczenie->connect_errno;
	}
	else{
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");
		
		if($result = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE login='%s' AND pass='%s'",
		mysqli_real_escape_string($polaczenie, $login),
		mysqli_real_escape_string($polaczenie, $password))))
		{
			$user_count = $result->num_rows;
			if ($user_count > 0){
				$_SESSION['logged_in'] = true;
				
				$row = $result->fetch_assoc();
				$_SESSION['id'] = $row['id'];
				$_SESSION['user'] = $row['user'];
				$_SESSION['login'] = $row['login'];
				$_SESSION['lvl'] = $row['lvl'];
				$_SESSION['email'] = $row['email'];
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
				
				$_SESSION['insufficient_glock'] = 0;
				$_SESSION['insufficient_awp'] = 0;
				$_SESSION['insufficient_minigun'] = 0;
				$_SESSION['insufficient_smg'] = 0;
				
				$_SESSION['max_glock'] = 0;
				$_SESSION['max_awp'] = 0;
				$_SESSION['max_minigun'] = 0;
				$_SESSION['max_smg'] = 0;
				//system lvlupowania, dodawania waluty, resetowania lvla na 100
				$id = $_SESSION['id'];
				
				@$polaczenie->query("UPDATE uzytkownicy SET logged_in = 1 WHERE id='$id'");

				unset($_SESSION['blad']);
				$result->close();
				header('Location: menu.php');
			}
			else{
				$_SESSION['blad'] = '<span style ="color:red">Incorrect login or password!</span>';
				header('Location: index.php');
			}
		}
		
		$polaczenie->close();
	}
?>