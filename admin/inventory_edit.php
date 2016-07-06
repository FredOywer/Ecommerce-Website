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
<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
if(isset($_POST['prodName'])){
	$pid = mysql_real_escape_string($_POST['thisID']);
	$prodName = mysql_real_escape_string($_POST['prodName']);
	$price = mysql_real_escape_string($_POST['price']);
	$category = mysql_real_escape_string($_POST['category']);
	$details = mysql_real_escape_string($_POST['details']);
	
	//check for duplicate product
	$sql = mysql_query("UPDATE products SET prod_name='$prodName', price='$price', category='$category', details='$details'
						 WHERE id='$pid'");
	if($_FILES['prodImage']['tmp_name'] != ''){
		$newName = "$pid.jpg";
		move_uploaded_file($_FILES['prodImage']['tmp_name'], '../images/inventory/$newName');
	}
	header('location: inventory.php');
	exit;
}
?>
<?php
if(isset($_GET['pid'])){
	$editID = $_GET['pid'];
	$sql = mysql_query("SELECT * FROM products WHERE id='$editID'");
	$prodCount = mysql_num_rows($sql);
	if($prodCount > 0){
		while($row = mysql_fetch_array($sql)){
			$id = $row['id'];
			$productName = $row['prod_name'];
			$price = $row['price'];
			$details = $row['details'];
			$category = $row['category'];
			$dateAdded = strftime("%b %d, %Y", strtotime($row['date_added']));
		}
	} else{
		$productList = 'That product doesn\'t exist';
		exit;
	}
}
?>
<html lang="en">
<head>
	
	<title>Admin View</title>
	<link type="text/css" rel="stylesheet" href="styles/admin_style.css" />	
	<script language="javascript" type="text/javascript">
		function validate(){
			var isValid = true;
			if(document.invForm.prodName.value == ""){
				alert("Enter Product Name");
				isValid = false;
			}
			if(document.invForm.price.value == ""){
				alert("Enter Product Price");
				isValid = false;
			}
			if(document.invForm.category.value == "0"){
				alert("Select a category");
				isValid = false;
			}
			if(document.invForm.details.value == ""){
				alert("Enter Product Details");
				isValid = false;
			}
			return isValid;
		}
	</script>
</head>

<div id="admin_main_div">
	<?php include 'header_admin.php'; ?>
	<br><br>
	<div style="background: #ccc">
		<h3 align="center">Edit Product</h3>
		
		<form action="inventory_edit.php" onsubmit="return validate();" enctype="multipart/form-data" name="invForm" id="invForm" method="POST">
			<table border="0" width="55%" cellpadding="6" cellspacing="0">
				<tr>
					<td align="right" width="30%">Name :</td>
					<td width="70%"><input type="text" name="prodName" value="<?php echo $productName; ?>" size="30"/></td>
				</tr>
				<tr>
					<td align="right">Price :</td>
					<td><input type="text" name="price" value="<?php echo $price; ?>" size="30"/></td>
				</tr>
				<tr>
					<td align="right">Details :</td>
					<td><textarea name="details" rows="4" cols="25"><?php echo $details; ?></textarea></td>
				</tr>
				<tr>
					<td align="right">Category :</td>
					<td>
					  <select name="category">
						  <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
						  <option value="Shirts">Shirts</option>
						  <option value="Shoes">Shoes</option>
						  <option value="Trousers">Trousers</option>
					  </select>
					</td>
				</tr>
				<tr>
					<td align="right">Image :</td>
					<td><input type="file" name="prodImage" size="30"/></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input name="thisID" type="hidden" value="<?php echo $editID; ?>"/>
					<td><input type="submit" value="Submit Changes"/></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="button" onclick="location.href='inventory.php';" value="Cancel"/></td>
				</tr>
			</table>
		</form>
		<hr>
		<?php include 'footer_admin.php'; ?>
	</div>
</div>
</html>