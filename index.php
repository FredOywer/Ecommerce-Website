<?php
require 'inc/dbconnect.php';
$latestProducts = '';
$sql = mysql_query("SELECT * FROM products ORDER BY rand() LIMIT 6");
$prodCount = mysql_num_rows($sql);
if($prodCount > 0){
	while($row = mysql_fetch_array($sql)){
		$id = $row['id'];
		$productName = $row['prod_name'];
		$price = $row['price'];
		$latestProducts.='';
		$latestProducts.=" 
						<div id='single_product'>
							<a href='product.php?id=$id'>
								<img src='images/inventory/$id.jpg' width='137' height='162' />
								<h3>$productName</h3>
								<p><i>Ksh $price</i></p>
							</a>
						</div>
						";
				
	}
} else{
	$latestProducts = 'All products are currently sold out';
}
mysql_close();
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<meta name="description"
            content="Your reliable store for shoes, shirts and trousers!">
		<meta name="keywords"
            content="style, fashion, online shop, store, buy, shopping">
		
	<title>ABC</title>
	<link type="text/css" rel="stylesheet" href="styles/main.css" />
	
</head>

<div id="main_div"> 
	<?php include 'inc/header.php'; ?>	
	
	<div id="main_section">
	
		<div id="left_nav">
			<dl>
				<dd>
					<a href="#">
						<div class="nav_text">Products</div>
					</a>
						<ul>
							<li>Shirts</li>
							<li>Trousers</li>
							<li>Shoes</li>
						</ul>
				</dd>
				<dd>
					<a href="#">
						<div class="nav_text">Brands</div>
					</a>
						<ul>
							<li>Zecchino</li>
							<li>Nico Men</li>
							<li>Yves Enzo</li>
							<li>Ralph Lauren</li>
							<li>Pacifique</li>
							<li>BATA</li>
						</ul>
				</dd>
			</dl>
			
		</div>

		<div id="content">	
			<div id="main_content_header">
				<center><h1>The Best in Fashion</h1></center>
			</div>
			
			<div id="slider">
				<ul class="slides">
					<li class="slide_item"><img src ="images/display/men2.jpg"></li>
					<li class="slide_item"><img src ="images/display/men3.jpg"></li>
					<li class="slide_item"><img src ="images/display/ladies1.jpg"></li>
					<li class="slide_item"><img src ="images/display/ladies2.jpg"></li>
					<li class="slide_item"><img src ="images/display/ladies3.jpg"></li>
					<li class="slide_item"><img src ="images/display/shoe1.png"></li>
					<li class="slide_item"><img src ="images/display/shoe2.jpg"></li>
					<li class="slide_item"><img src ="images/display/shoe3.jpg"></li>
					<li class="slide_item"><img src ="images/display/shoe4.jpg"></li>
					<li class="slide_item"><img src ="images/display/shoe5.jpg"></li>
					<li class="slide_item"><img src ="images/display/shoe6.jpg"></li>
				</ul>
			</div>
			
			<div id="products_div">
				<?php echo $latestProducts; ?>
			</div>
			
			<!--
			<div id="latest">
				<table border="1" cellspacing="0" cellpadding="5">
					<tr>
						<td valign="top" align="center">
							<p>Latest Arrivals<p>
							<p><br></p>
						</td>
					</tr>
				</table>
			</div>
			-->
				
			<!--
			<div id="home_shirts" class="home_sliders">
				<a href="#" class="content_header">Shirts</a>
				<ul class="home_slides">
					<li class="home_slide_item"><img src="images/shirts/shirt1.jpeg"></li>
					<li class="home_slide_item"><img src="images/shirts/shirt2.jpg"></li>
					<li class="home_slide_item"><img src="images/shirts/shirt3.jpg"></li>
					<li class="home_slide_item"><img src="images/shirts/shirt4.jpg"></li>
					<li class="home_slide_item"><img src="images/shirts/shirt5.jpg"></li>
					<li class="home_slide_item"><img src="images/shirts/shirt6.jpg"></li>
					<li class="home_slide_item"><img src="images/shirts/shirt7.jpg"></li>
				</ul>
			</div>
			
			<div id="home_trousers" class="home_sliders">
				<a href="#" class="content_header">Trousers</a>
				<ul class="home_slides">
					<li class="home_slide_item"><img src="images/trousers/trousers1.jpg"></li>
					<li class="home_slide_item"><img src="images/trousers/trousers2.jpg"></li>
					<li class="home_slide_item"><img src="images/trousers/trousers3.jpg"></li>
					<li class="home_slide_item"><img src="images/trousers/trousers4.jpg"></li>
					<li class="home_slide_item"><img src="images/trousers/trousers5.jpg"></li>
					<li class="home_slide_item"><img src="images/trousers/trousers6.jpg"></li>
					<li class="home_slide_item"><img src="images/trousers/trousers7.jpg"></li>
					<li class="home_slide_item"><img src="images/trousers/trousers8.jpg"></li>
				</ul>
			</div>
			
			<div id="home_shoes" class="home_sliders">
				<a href="#" class="content_header">Shoes</a>
				<ul class="home_slides">
					<li class="home_slide_item"><img src="images/shoes/shoe1.jpg"></li>
					<li class="home_slide_item"><img src="images/shoes/shoe2.jpg"></li>
					<li class="home_slide_item"><img src="images/shoes/shoe3.jpg"></li>
					<li class="home_slide_item"><img src="images/shoes/shoe4.jpg"></li>
					<li class="home_slide_item"><img src="images/shoes/shoe5.jpg"></li>
					<li class="home_slide_item"><img src="images/shoes/shoe6.jpg"></li>
					<li class="home_slide_item"><img src="images/shoes/shoe7.jpg"></li>
					<li class="home_slide_item"><img src="images/shoes/shoe8.jpg"></li>
				</ul>
			</div>
			-->
		</div>			
	</div>
	
	<?php include 'inc/footer.php'; ?>
	
</div>
	
	<script src="scripts/jquery-2.1.4.js"></script>
	<script src="scripts/main.js"></script>

</html>