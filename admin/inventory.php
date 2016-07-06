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
//Delete
if(isset($_GET['delID'])){
	echo 'Delete product of ID &nbsp;'.$_GET['delID'].'? <a href="inventory.php?yesdelete='.$_GET['delID'].'">Yes</a> &nbsp;| &nbsp;<a href="inventory.php">No</a>';
	exit;
}
if(isset($_GET['yesdelete'])){
	$idToDelete=$_GET['yesdelete'];
	$query = mysql_query("DELETE FROM products WHERE id='$idToDelete'") or die(mysql_error);
	$picToDelete = ('../images/inventory/$idToDelete.jpg');
	if(file_exists($picToDelete)){
		unlink($picToDelete);
	}
	header('location: inventory.php');
	exit;
}

?>
<?php
if(isset($_POST['prodName'])){
	$prodName = mysql_real_escape_string($_POST['prodName']);
	$price = mysql_real_escape_string($_POST['price']);
	$category = mysql_real_escape_string($_POST['category']);
	$details = mysql_real_escape_string($_POST['details']);
	
	//check for duplicate product
	$sql = mysql_query("SELECT id FROM products WHERE prod_name='$prodName'");
	$prodMatch = mysql_num_rows($sql);
	if($prodMatch > 0){
		echo "There's already an item that exists with the name &nbsp;".$prodName.", view it <a href='inventory.php'>Here</a>";
		exit();
	}
	$query = mysql_query("INSERT INTO products (prod_name, price, details, category, date_added)
						VALUES('$prodName', '$price', '$details', '$category', now())") or die(mysql_error());
	$pid = mysql_insert_id();
	//place image in folder
	$newName = "$pid.jpg";
	move_uploaded_file($_FILES['prodImage']['tmp_name'], "../images/inventory/$newName");
	header('location: inventory.php');
	exit;
}
?>

<?php
$productList = '';
$sql = mysql_query("SELECT * FROM products ORDER BY date_added DESC");
$prodCount = mysql_num_rows($sql);
if($prodCount > 0){
	while($row = mysql_fetch_array($sql)){
		$id = $row['id'];
		$productName = $row['prod_name'];
		$dateAdded = strftime("%b %d, %Y", strtotime($row['date_added']));
		$productList = "$productList $id &nbsp; - &nbsp; $productName &nbsp; - &nbsp; $dateAdded &nbsp;
		<a href='inventory_edit.php?pid=$id'>Edit</a> &nbsp; &bull; &nbsp;<a href='inventory.php?delID=$id'>Remove</a><br>";
	}
} else{
	$productList = 'You have not yet added any products';
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
			if(document.invForm.prodImage.value == ""){
				alert("Upload an Image for the Product");
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
		<div id="inv_btns">
			<a href="inventory.php#prodForm" name="btnAdd">+ Add Product</a>
		</div>
		<br>
		<hr>
		<h3>Available Inventory</h3>
		<?php echo $productList; ?>
		<br><br>
		<hr>
		<h3>Add Product</h3>
		
		<form action="inventory.php" onsubmit="return validate();" enctype="multipart/form-data" name="invForm" id="invForm" method="POST">
			<table border="0" width="55%" cellpadding="6" cellspacing="0">
				<tr>
					<td align="right" width="30%">Name :</td>
					<td width="70%"><input type="text" name="prodName" size="30"/></td>
				</tr>
				<tr>
					<td align="right">Price :</td>
					<td><input type="text" name="price" size="30"/></td>
				</tr>
				<tr>
					<td align="right">Details :</td>
					<td><textarea name="details" rows="4" cols="25"></textarea></td>
				</tr>
				<tr>
					<td align="right">Category :</td>
					<td>
					  <select name="category">
						  <option value="0">Select Category</option>
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
					<td><input type="submit" value="Add Product"/></td>
				</tr>
			</table>
		</form>
		<br>
		<hr>
		<?php include 'footer_admin.php'; ?>
	</div>
</div>


</html>