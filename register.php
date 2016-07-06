<?php
session_start();
if(isset($_SESSION['customer']) && $_SESSION['customer']!="")
{
	
}

?>
<script type="text/javascript">
function validateReg() {
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	var confirm = document.getElementById('confirm_pass').value;
	var first = document.getElementById('firstname').value;
	var last = document.getElementById('surname').value;
	var email = document.getElementById('email').value;
	
	if(username ==='' || password ==='' || confirm ==='' || first ==='' || last ==='' || email ===''){
		alert("Enter all fields");
	}
	else{
		if (password != confirm){
			alert("Passwords do not match");	
		}
		else{
			return true;
		}
	}
    return false;
}
</script>
<?php
if(isset($_GET['warning']) && $_GET['warning']=='invalid')
{
	$content='<div class="alert alert-warning">';
	$content.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
	$content.='Invalid Access.';
	$content.='</div>';
	echo $content;
}
else if(isset($_GET['warning']) && $_GET['warning']=='username')
{
	$content='<div class="alert alert-warning">';
	$content.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
	$content.='Username already exists, Try a different one';
	$content.='</div>';
	echo $content;
}
else if(isset($_GET['error']) && $_GET['error']=='error')
{
	$content='<div class="alert alert-warning">';
	$content.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
	$content.='Registration Failed, Try Again.';
	$content.='</div>';
	echo $content;
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
	<div class="bordered_div">
		<h2>Register a customer account</h2>
		<hr>
		<form action="methods/createcustomer.php" method="POST" enctype="multipart/form-data">
			<br>
			<div style="text-align:center;">
				Username: <br><input type="text" class="input_field" id="username" name="username" maxlength="25" value=""><br><br>
				Password: <br><input type="password" class="input_field" id="password" name="password" ><br><br>
				Confirm Password: <br><input type="password" class="input_field" id="confirm_pass" name="confirm_pass"><br><br>
				Firstname: <br><input type="text" class="input_field" id="firstname" name="firstname" maxlength="25" value=""><br><br>
				Surname: <br><input type="text" class="input_field" id="surname" name="surname" maxlength="25" value=""><br><br>
				Email: <br><input type="text" class="input_field" id="email" name="email" maxlength="30" value=""><br><br><br>
				<input type="submit" id="btnReg" name="btnReg" class="btn" style="width: 250px; padding: 5px 22px;" value="Register" onclick="return validateReg()"/>
			</div>
		</form>
	</div>
	<?php include 'inc/footer.php'; ?>
</div>

