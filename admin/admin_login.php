<?php
session_start();
if(isset($_SESSION['admin'])){
	header('location: index.php');
	exit();
}

if(isset($_POST['username']) && isset($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if (!empty($username) && !empty($password)){
		include '../inc/dbconnect.php';
		$sql = mysql_query("SELECT id FROM admin WHERE username='$username' AND password='$password'");
		$count = mysql_num_rows($sql);
		if($count==1){
			while($row = mysql_fetch_array($sql)){
				$id = $row['id'];
			}
			$_SESSION['id'] = $id;
			$_SESSION['admin'] = $username;
			$_SESSION['password'] = $password;
			header('location: index.php');
			exit();
		} else{
			echo 'Wrong details, try again <a href="index.php">Click Here</a>';
			exit();
		}
	} else{
		echo 'Enter admin details';
	}
}

?>

<style type="text/css">
#adminDiv{
	background: #ccc;
	padding-top: 15px;
	padding-bottom: 20px;
	margin-left: 500px;
	margin-right: 500px;
}
#adminDiv h2{
	font-size: 35px;
	color: #BD7E1D;
}
</style>


<div id="adminDiv" align="center">
	<h2>Admin Login</h2>
	<hr>
	<br><br>
	<form action="admin_login.php" method="POST">
		Username: <input type="text" name="username"/>
		<br><br>
		Password: <input type="password" name="password"/>
		<br><br><br>
		<input type="submit" value="Login">
	</form>
</div>

