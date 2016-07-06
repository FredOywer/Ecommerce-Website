<?php
session_start();
require 'inc/dbconnect.php';

if($_SESSION['customer']!="")
{
	echo '<script> window.location="index.php?warning=login"</script>';
	exit();
}
?>
<script type="text/javascript">
function validateUser() {
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	
	if(username ==='' || password ===''){
		alert("Enter all fields");
		return false;
	}
    return true;
}
</script>
<?php
$username='';
	if(isset($_GET['error']) && $_GET['error']=='login'){
		$username = $_GET['value'];
		echo '<script>alert("Incorrect Username or Password. Try again")</script>';
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<meta name="description"
            content="The best online store for shoes, shirts and trousers!">
		<meta name="keywords"
            content="style, fashion, online shop, store, buy, shopping">
		
	<title>ABC</title>
	<link type="text/css" rel="stylesheet" href="styles/main.css" />
</head>
<div id="main_div"> 
	<?php include 'inc/header.php'; ?>
	<div class="bordered_div" style="width: 250px; margin-left: auto; margin-right: auto;">
		<h2>Sign In</h2>
		<hr>
		<form action="methods/login.php" method="POST">
			<br>
			<div>
				Username: <br><input type="text" class="input_field" id="username" name="username" maxlength="25" value="<?php echo $username; ?>"><br><br>
				Password: <br><input type="password" class="input_field" id="password" name="password" ><br><br>
				<input type="submit" id="btnLogin" name="btnLogin" class="btn" style="width: 250px; padding: 5px 22px;" value="Sign In" onclick="return validateUser()"/>
			</div>
		</form>
	</div>
	<?php include 'inc/footer.php'; ?>
</div>