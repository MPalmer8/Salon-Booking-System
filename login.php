<link rel="stylesheet" type = "text/css" href="CSS/style.css">

<?php
session_start();
$message="";
if(count($_POST)>0) {
 $con = mysqli_connect('localhost','root','','coursework') or die('Unable To connect');

$passcode = $_POST["Passcode"];
$hashed_passcode = password_hash($passcode, PASSWORD_BCRYPT);

// This searches the customer table to see if the username and password are in the table, if they are, the customer is logged in 
$result = mysqli_query($con,"SELECT * FROM Customer WHERE Username='" . $_POST["Username"] . "'");
$row  = mysqli_fetch_array($result);
$result2 = mysqli_query($con,"SELECT Passcode FROM Customer WHERE Username='" . $_POST["Username"] . "'");
$row2  = mysqli_fetch_array($result2);
// The password that the user has typed in is verified against the hashed password in the customer table 
if((is_array($row)) And password_verify($passcode,$row2["Passcode"])) {
$_SESSION["CustomerID"] = $row['CustomerID'];
$_SESSION["FirstName"] = $row['FirstName'];
} 
// This searches the staff table to see if the username and password are in the table, if they are, the staff member is logged in 
else {
    $result = mysqli_query($con,"SELECT * FROM staff WHERE StaffUsername='" . $_POST["Username"] . "'");
    $row  = mysqli_fetch_array($result);
    $result2 = mysqli_query($con,"SELECT Passcode FROM staff WHERE StaffUsername='" . $_POST["Username"] . "'");
    $row2  = mysqli_fetch_array($result2);
    // The password that the user has typed in is verified against the hashed password in the staff table 
    if((is_array($row)) And password_verify($passcode,$row2["Passcode"])) {
        $_SESSION["StaffID"] = $row['StaffID'];
        $_SESSION["StaffFirstName"] = $row['StaffFirstName'];
        if(isset($_SESSION["StaffID"])) {
            header("Location:shome.php");}
    }
    else{$message = "Invalid Username or Password!"; }
}
}
if(isset($_SESSION["CustomerID"])) {
header("Location:chome.php");
}

?>
<html>
<head>
<title>Customer Login</title>
</head>
<body>
<?php include 'header.php';?> <?php include 'menu.php';?>
<form name="frmUser" method="post" action="" align="center">
<div class="message"></div>
<h3 align="center">Enter Customer Login Details</h3>
<div class=loginbox>
<label for="Username">Username:<br></label>
<input type="text" name="Username">
<br>
<label for="Passcode">Password:<br></label>
<input type="password" name="Passcode">
<br><br>
<input type="submit" name="submit" value="Submit">
<input type="reset"><br><br>
</div>
<?php if($message!="") { echo "<div class='validation'>", $message, "</div>"; } ?>
<!-- <a align="center" href="Stafflogin.php">Staff Login</a> -->
</form><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php';?>

<link rel="stylesheet" type = "text/css" href="CSS/style.css">
</body>
</html>
