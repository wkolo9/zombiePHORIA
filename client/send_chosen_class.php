<?php
	session_start();
	
	require_once "db_connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno != 0){
		echo "Error: ".$polaczenie->connect_errno;
	}
	else{
		if (isset($_POST['sniper'])){
			$sniper = $_POST['sniper'];
			echo $sniper;
		}
		
		if (isset($_POST['heavy'])){
			$heavy = $_POST['heavy'];
			echo $heavy;
		}
		
		if (isset($_POST['speedy'])){
			$speedy = $_POST['speedy'];
			echo $speedy;
		}
		
		$id = $_SESSION['id'];

		if(isset($sniper) && $sniper !== 0)
		{
			@$polaczenie->query("UPDATE uzytkownicy SET chosen_class = 1 WHERE id='$id'");
			header('Location: http://localhost:2000/');
		}
		
		if(isset($heavy) && $heavy !== 0)
		{
			@$polaczenie->query("UPDATE uzytkownicy SET chosen_class = 2 WHERE id='$id'");
			header('Location: http://localhost:2000/');
		}
		
		if(isset($speedy) && $speedy !== 0)
		{
			@$polaczenie->query("UPDATE uzytkownicy SET chosen_class = 3 WHERE id='$id'");
			header('Location: http://localhost:2000/');
		}

		}
		$polaczenie->close();
?>