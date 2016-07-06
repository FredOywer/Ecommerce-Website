<?php
session_start();
if(!isset($_SESSION['admin'])){
	header('location: admin_login.php');
	exit();
}

$adminID = preg_replace('#[^0-9]#i', '', $_SESSION['id']);
$admin = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION['admin']);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION['password']);

include '../inc/dbconnect.php';

$sql = mysql_query("SELECT * FROM admin WHERE id='$adminID' AND username='$admin' AND password='$password'");
$count = mysql_num_rows($sql);
if($count==0){
	header('location:../index.php');
	exit();
}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin View</title>
	<link type="text/css" rel="stylesheet" href="styles/admin_style.css" />	
</head>
<div id="admin_main_div">
	<div>
		<h2><?php echo "Welcome Admin --" .$_SESSION['admin']; ?><h2>
		<?php include 'header_admin.php'; ?>
	</div>
	<div id="options">
		<ul>
			<li><a href="inventory.php">Manage Inventory</a></li>
			<li><a href="#">Manage...</a></li>
		</ul>
	<hr>
	</div>
	<?php include 'footer_admin.php'; ?>
</div>

</html>