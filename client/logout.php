<?php
	session_start();
	
	require_once "db_connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	$id = $_SESSION['id'];
	
	if ($polaczenie->connect_errno != 0){
		echo "Error: ".$polaczenie->connect_errno;
	}
	else{
		@$polaczenie->query("UPDATE uzytkownicy SET logged_in=0 WHERE id='$id'");
	}
	session_unset();
	$polaczenie->close();
	header ('Location: index.php');
?>

