<?php
$host='host';
$username='username';
$pass='password';
$dbName='database_name';

$con= mysqli_connect($host,$username,$pass, $dbName) or die(mysqli_error($con));
mysqli_query($con, "SET NAMES utf8");
?>