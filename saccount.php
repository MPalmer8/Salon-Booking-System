<?php include 'header.php';?> <?php include 'staffmenu.php';?><?php session_start(); ?>
<?php if($_SESSION["StaffID"]){echo "";}else{header("Location:home.php");} ?> <?php
$staff = $_SESSION["StaffID"];
require_once 'connect.php'; require_once 'header.php';  require_once 'staffmenu.php';
echo "<div class='container'>";
#This will select all of the information from the staff table in the database that relates to the current staff member logged in
$sql = "SELECT * FROM Staff WHERE StaffID = $staff";
$result = $con->query($sql);
if( $result->num_rows > 0){ ?>
<h2 align="center">Your Account</h2>
<html>
<body>
<table class="table table-bordered table-striped" align="center">
<tr>
<td>Firstname</td>
<td>Lastname</td>
<td>Username</td>
<td width="70px">EDIT</td>
<td>PASSWORD RESET</td></tr>
<?php
while( $row = $result->fetch_assoc()){
echo "<form action='' method='POST'>"; //added
echo "<input type='hidden' value='". $row['StaffID']."' name='CustomerID' />"; //added
echo "<tr>";
echo "<td>".$row['StaffFirstName'] . "</td>";
echo "<td>".$row['StaffLastName'] . "</td>";
echo "<td>".$row['StaffUsername'] . "</td>";
echo "<td><a href='staffedit.php?id=".$row['StaffID']."' class='btn btn-info'>Edit</a></td>";
echo "<td><a href='passresetstaff.php?id=".$row['StaffID']."' class='btn btn-info'>Reset</a></td>";
echo "</tr>";
echo "</form>"; //added
}
?>
</table>
<br><br><br><br><br><br><br><br><br><br><br><br>
<?php }else{echo "<br><br>No Record Found";}?>
<?php include 'footer.php';?>
</div>





