<?php
require '../inc/dbconnect.php';

$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);
$pass_hash = md5($password);

$query = "SELECT username FROM customers WHERE username='$username' AND password='$pass_hash'";
$result = mysql_query($query);

if($result){
	if(mysql_num_rows($result) == 1){
		session_start();
		$_SESSION['customer'] = $username;
		echo '<script> window.location="../index.php"</script>';
		exit();	
	}
	else{
		echo '<script> window.location="../login.php?error=login&value='.$username.'"</script>';
		//header("Location=abcs.php");
		exit();
	}
}
else{
	echo '<script> window.location="../login.php?error=error"</script>';
	exit();
}

?>