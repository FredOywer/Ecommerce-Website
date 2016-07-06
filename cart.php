<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require 'inc/dbconnect.php';

if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
	$wasFound = false;
	$i = 0;
	if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
		$_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
	}
	else {
		foreach ($_SESSION["cart_array"] as $each_item) {
		  $i++;
		  while (list($key, $value) = each($each_item)) {
			  if ($key == "item_id" && $value == $pid) {
			  // Item already exists in cart, so increase quantity
			  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
			  $wasFound = true;
			}
		  }
		}
	   if ($wasFound == false) {
		   array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
		}
	}
	header("location: cart.php"); 
    exit();
}

if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}

if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
    // Remove one item from cart
 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}

if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity);
	if ($quantity >= 100) { $quantity = 99; }
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) {
		$i++;
		while (list($key, $value) = each($each_item)) {
			if ($key == "item_id" && $value == $item_to_adjust) {
				// Item already exists in cart, so increase quantity
				array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
			}
		}
	}
	header("location: cart.php"); 
    exit();
}
?>
<?php
$cartOutput = "";
$cartTotal = "";
$btnCheckout = '';
$product_id_array = '';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
	// Checkout
	$btnCheckout .= '<form align="right" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="you@yourpaypallemail.com">';
	// Start the For Each loop
	$i = 0; 
    foreach ($_SESSION["cart_array"] as $each_item) { 
		$item_id = $each_item['item_id'];
		$sql = mysql_query("SELECT * FROM products WHERE id='$item_id' LIMIT 1");
		while ($row = mysql_fetch_array($sql)) {
			$product_name = $row["prod_name"];
			$price = $row["price"];
			$details = $row["details"];
		}
		$pricetotal = $price * $each_item['quantity'];
		$cartTotal = $pricetotal + $cartTotal;
		//setlocale(LC_MONETARY, "en_US");
        //$pricetotal = money_format("%10.2n", $pricetotal);
		// Dynamic Checkout Btn Assembly
		$x = $i + 1;
		$btnCheckout .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
        <input type="hidden" name="amount_' . $x . '" value="' . $price . '">
        <input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';
		// Create the product array variable
		$product_id_array .= "$item_id-".$each_item['quantity'].","; 
		// Dynamic table row assembly
		$cartOutput .= "<tr>";
		$cartOutput .= '<td class="table_data" align="center"><img src="images/inventory/' . $item_id . '.jpg" alt="' . $product_name. '" width="60" height="72" /><br><a href="product.php?id=' . $item_id . '">' . $product_name . '</a></td>';
		$cartOutput .= '<td align="center">' . $details . '</td>';
		$cartOutput .= '<td align="center">KES<br>' . $price . '</td>';
		$cartOutput .= '<td align="center"><form action="cart.php" method="post">
		<input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="2" />
		<input name="adjustBtn' . $item_id . '" type="submit" value="change" />
		<input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
		</form></td>';
		//$cartOutput .= '<td>' . $each_item['quantity'] . '</td>';
		$cartOutput .= '<td align="center">' . $pricetotal . '</td>';
		$cartOutput .= '<td align="center"><form action="cart.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="X" /><input name="index_to_remove" type="hidden" value="' . $i . '" /></form></td>';
		$cartOutput .= '</tr>';
		$i++; 
    } 
	//setlocale(LC_MONETARY, "en_US");
    //$cartTotal = money_format("%10.2n", $cartTotal);
	$cartTotal = "<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total : KES&nbsp;".$cartTotal."</div>";
    // Finish the Paypal Checkout Btn
	$btnCheckout .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
	<input type="hidden" name="notify_url" value="https://www.yoursite.com/storescripts/my_ipn.php">
	<input type="hidden" name="return" value="https://www.yoursite.com/checkout_complete.php">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="cbt" value="Return to The Store">
	<input type="hidden" name="cancel_return" value="https://www.yoursite.com/paypal_cancel.php">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="currency_code" value="USD">
	<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">
	</form>';
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shopping Cart</title>
<link rel="stylesheet" href="styles/main.css" type="text/css" />
</head>
<body>
<div align="center" id="main_div">
	<?php include 'inc/header.php'; ?>
	  <div id="main_section">
		<div style="margin:24px; text-align:left;"><br>
			<table width="100%" border="1" cellspacing="2" cellpadding="0">
				  <tr>
					<td style="text-align: center;" width="18%" bgcolor="#BD7E1D"><strong>Product</strong></td>
					<td style="text-align: center;" width="45%" bgcolor="#BD7E1D"><strong>Product Description</strong></td>
					<td style="text-align: center;" width="10%" bgcolor="#BD7E1D"><strong>Unit Price</strong></td>
					<td style="text-align: center;" width="9%" bgcolor="#BD7E1D"><strong>Quantity</strong></td>
					<td style="text-align: center;" width="9%" bgcolor="#BD7E1D"><strong>Total</strong></td>
					<td style="text-align: center;" width="9%" bgcolor="#BD7E1D"><strong>Remove</strong></td>
				  </tr>
				 <?php echo $cartOutput; ?>
			</table>
			<?php echo $cartTotal; ?>
			<?php echo $btnCheckout; ?>
			<a style="color: #BD7E1D;" type="button" href="cart.php?cmd=emptycart">Empty Cart</a>
		</div><br>
	  </div>
	<?php include 'inc/footer.php'; ?>
</div>
</body>
</html>