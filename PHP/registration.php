<?php error_reporting(0);?>
<!DOCTYPE html> 
<head>
<title>Registration Form</title>
<style>
.errormsg{color:red;}

input:required {
  border-color: red !important;
}
input:required + label {
  color: red;
}
.formHolder {display : block; margin : 140px 370px; background-color:lightblue; width : 390px; padding: 30px; 
border-radius: 10px; border: 1px solid black; box-shadow : 10px 10px #cccccc; font-family:sans-serif}


</style>
</head>
 
<body>
<?php include("registrationProcess.php"); ?>
<div class="formHolder">
<form method="post" action="" name="form">
	
	<table border="0">
		<tr>
			<td>&nbsp;</td>
			<td><h3>Registration Form</h3></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>First Name :</td>
			<td><input type="text" name="firstName" value="<?php echo $val_firstname; ?>" required /></td>
			<td><?php echo $errmsg_firstname; ?></td>
		</tr>
		<tr>
			<td>Last Name :</td>
			<td><input type="text" name="lastName" value="<?php echo $val_lastname; ?>" required /></td>
			<td><?php echo $errmsg_lastname; ?></td>
		</tr>
		<tr>
			<td>Password :</td>
			<td><input type="password" name="password" value="<?php echo $val_password; ?>" required /></td>
			<td><?php echo $errmsg_password; ?></td>
		</tr>
		
		<tr>
			<td>Email : </td>
			<td><input type="text" name="email" value="<?php echo $val_email; ?>" required /></td>
			<td><?php echo $errmsg_email; ?></td>
			
			
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="button" id="button" value="Submit" /> &nbsp; &nbsp <a href="login.php"> Login Here</a></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
</div>
</body>
</html>