<?php
session_start();
$message="";
if(count($_POST)>0) {
 $con = mysqli_connect('localhost','root','','s1901551') or die('Unable To connect');
$result = mysqli_query($con,"SELECT * FROM staff WHERE StaffUsername='" . $_POST["Username"] . "' and Passcode = '". $_POST["Passcode"]."'");
$row  = mysqli_fetch_array($result);
if(is_array($row)) {
$_SESSION["StaffID"] = $row['StaffID'];
$_SESSION["StaffFirstName"] = $row['StaffFirstName'];
} else {
$message = "Invalid Username or Password!";
}
}
if(isset($_SESSION["StaffID"])) {
header("Location:index.php");
}
?>
<html>
<head>
<title>Staff Login</title>
</head>
<body>
<?php include 'header.php';?> <?php include 'menu.php';?>
<form name="frmUser" method="post" action="" align="center">
<div class="message"><?php if($message!="") { echo $message; } ?></div>
<h3 align="center">Enter Staff Login Details</h3>
 Username:<br>
 <input type="text" name="Username">
 <br>
 Password:<br>
<input type="password" name="Passcode">
<br><br>
<input type="submit" name="submit" value="Submit">
<input type="reset"><br><br>
</form>
<?php include 'footer.php';?>

<link rel="stylesheet" type = "text/css" href="CSS/style.css">
</body>
</html>