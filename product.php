<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (isset($_GET['id'])){
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']);
	require 'inc/dbconnect.php';
	$sql = mysql_query("SELECT * FROM products WHERE id='$id' LIMIT 1")or die(mysql_error());
	$prodCount = mysql_num_rows($sql);
	if($prodCount > 0){
		while($row = mysql_fetch_array($sql)){
			$productName = $row['prod_name'];
			$price = $row['price'];
			$details = $row['details'];
			$category = $row['category'];
			$dateAdded = strftime("%b %d, %Y", strtotime($row['date_added']));
		}
	} else{
		echo "Data to render this page is missing.";
		exit();
	}
	mysql_close();
}else{
	echo "Data to render this page is missing.";
	exit();
}
?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $productName; ?></title>
	<link type="text/css" rel="stylesheet" href="styles/main.css" />
</head>

<div id="main_div"> 
	<?php include 'inc/header.php'; ?>
	<div id="main_section">
		<table width="100%" border="0" cellspacing="0" cellpadding="15">
			<tr>
				<td width="19%" valign="top"><a href="images/inventory/<?php echo $id; ?>.jpg"><img src="images/inventory/<?php echo $id; ?>.jpg" width="142" height="188" alt="<?php echo $productName; ?>" /></a><br>
				  <a href="images/inventory/<?php echo $id; ?>.jpg">View Full Size Image</a>
				</td>
				<td width="81%" valign="top"><h3><?php echo $productName; ?></h3>
					<p><?php echo "KES &nbsp;".$price; ?><br><br>
						<?php echo $details; ?><br><br>
						<?php echo "Category:&nbsp;".$category; ?><br>
					</p>
				  
				  <form id="buyform" name="buyform" method="post" action="cart.php">
					<input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>" />
					<input type="submit" name="button" id="button" value="Add to Cart" />
				  </form>
				</td>
			</tr>
		</table>
	</div>
	
	<?php include 'inc/footer.php'; ?>
	
</div>
</html>