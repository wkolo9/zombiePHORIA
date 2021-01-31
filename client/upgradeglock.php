<?php
	session_start();
	
	require_once "db_connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno != 0){
		echo "Error: ".$polaczenie->connect_errno;
	}
	else{
		if($_SESSION['lvl_glock'] < 10)
		{
			if(($_SESSION['currency'] > ($_SESSION['lvl_glock'] + 1) * 200) || ($_SESSION['currency'] == ($_SESSION['lvl_glock'] + 1) * 200))
			{
				$id = $_SESSION['id'];
				
				$_SESSION['currency'] = $_SESSION['currency'] - ($_SESSION['lvl_glock'] + 1) * 200;
				$currency = $_SESSION['currency'];
				
				$lvl_glock = $_SESSION['lvl_glock'] + 1;
				$_SESSION['lvl_glock'] = $_SESSION['lvl_glock'] + 1;
				
				@$polaczenie->query("UPDATE uzytkownicy SET lvl_glock = '$lvl_glock', currency = '$currency' WHERE id='$id'");
				header('Location: shop.php');
			}
			else
			{
				$_SESSION['insufficient_glock'] = 1;
				header('Location: shop.php');
			}
		}
		else
		{
			$_SESSION['max_glock'] = 1;
			header('Location: shop.php');				
		}
		$polaczenie->close();
	}
?>