<?php
require '../inc/dbconnect.php';

$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);
$pass_hash = md5($password);
$firstname = mysql_real_escape_string($_POST['firstname']);
$lastname = mysql_real_escape_string($_POST['surname']);
$email = mysql_real_escape_string($_POST['email']);

$query = "SELECT username, email FROM customers WHERE username='$username' || email='$email'";
$result = mysql_query($query);

if(mysql_num_rows($result) == 0){
	$query1 = "INSERT INTO customers(username,firstname,lastname,email,password) VALUES('$username','$firstname','$lastname','$email','$pass_hash')";
	$result1 = mysql_query($query1);
	if($result1)
	{
		session_start();
		$_SESSION['customer'] = $username;
		echo '<script> window.location="../index.php?success=register"</script>';
		exit();
	}
	else
	{
		echo '<script> window.location="../register.php?error=error"</script>';
		exit();
	}		
}
else{
	echo '<script> window.location="../register.php?warning=username"</script>';
	exit();
}
?>