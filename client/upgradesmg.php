<?php
	session_start();
	
	require_once "db_connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno != 0){
		echo "Error: ".$polaczenie->connect_errno;
	}
	else{
		if($_SESSION['lvl_smg'] < 10)
		{
			if(($_SESSION['currency'] > ($_SESSION['lvl_smg'] + 1) * 200) || ($_SESSION['currency'] == ($_SESSION['lvl_smg'] + 1) * 200))
			{
				$id = $_SESSION['id'];
				
				$_SESSION['currency'] = $_SESSION['currency'] - ($_SESSION['lvl_smg'] + 1) * 200;
				$currency = $_SESSION['currency'];
				
				$lvl_smg = $_SESSION['lvl_smg'] + 1;
				$_SESSION['lvl_smg'] = $_SESSION['lvl_smg'] + 1;
				
				@$polaczenie->query("UPDATE uzytkownicy SET lvl_smg = '$lvl_smg', currency = '$currency' WHERE id='$id'");
				header('Location: shop.php');
			}
			else
			{
				$_SESSION['insufficient_smg'] = 1;
				header('Location: shop.php');
			}
		}
		else
		{
			$_SESSION['max_smg'] = 1;
			header('Location: shop.php');			
		}
		$polaczenie->close();
	}
?>