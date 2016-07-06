<?php
session_start();
$contentAc='';
if (isset($_SESSION['customer']) && $_SESSION['customer'] !=''){
	$contentAc = '<div>
				</div';
}
?>

<div id="header_wrapper">
	<a href="index.php"><img id="logo" src="images/logo.jpg" width="100" height="100" /></a>
	<div id="searchBox">
		<form action="search.php" method="GET">
			<input type="search" class="search" name="search" placeholder="Search for Products" />
			<input type="submit" class="btn" style="position:relative; height: 48px; width: 150px; left: -5px; " name="search" value="SEARCH" />
		</form>
	</div>
	<div id="cart">
		<div class="dropdown">
			<a href="account.php" class="droplink"><img src="images/user.png" height="48" width="48" /><p>Account</p></a>
			<div id="dropdown_content">
				<a href="login.php">Login</a>
				<a href="register.php">Register</a>
			</div>
		</div>&nbsp; &nbsp;
		<a href="cart.php"><img src="images/cart.png" /><p>Cart</p></a>
	</div>
</div>

<div id="navigation">
	<ul>
		<li id="currentpage"><a href="index.php">Home</a></li>
		<li><a href="about.php">About Us</a></li>
		<li>
			<div class="dropdown">
			  <a class="droplink">Products</a>
			  <div class="nav_dropdown_content">
				<a href="#">Shirts</a>
				<a href="#">Trousers</a>
				<a href="#">Shoes</a>
			  </div>
			</div>
		</li>
		<li><a href="#">Contact Us</a></li>
		<li><a href="#">Help?</a></li>
		<li style="float: right; font-weight: bold;">Welcome <span style="color: FB9903"><?php
			if($_SESSION['customer'] !=''){echo $_SESSION['customer'];} else{echo 'Guest';} ?></span>
		</li>
	</ul>
</div>
