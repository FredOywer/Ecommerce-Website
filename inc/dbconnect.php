<?php 

$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = 'root';
$mysql_db = 'shop';

mysql_connect("$mysql_host", "$mysql_user", "$mysql_pass") or die("Could not connect to the database".mysql_error());
mysql_select_db("$mysql_db") or die("Db not available");

?>