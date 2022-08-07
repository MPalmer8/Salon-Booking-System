<?php
session_start(); 
if($_SESSION["StaffID"]){echo "";}else{header("Location:home.php");}
require_once 'connect.php'; require_once 'header.php';  require_once 'staffmenu.php';
echo "<div class='container'>";
#This will select all of the information from the customer table and display it in a table format
$sql = "SELECT * FROM Customer";
$result = $con->query($sql);
if( $result->num_rows > 0){ ?>
<h2 align="center">Select a Customer</h2>
<html>
<body>
<table class="table table-bordered table-striped" align="center">
<tr>
<td>Firstname</td>
<td>Lastname</td>
<td>Username</td>
<td>Tel</td>
<td>E-Mail</td>
<td width="70px">SELECT</td>
</tr> <?php
#This will output the information
while( $row = $result->fetch_assoc()){
echo "<form action='' method='POST'>"; 
echo "<input type='hidden' value='". $row['CustomerID']."' name='CustomerID' />"; 
echo "<tr>";
echo "<td>".$row['FirstName'] . "</td>";
echo "<td>".$row['LastName'] . "</td>";
echo "<td>".$row['Username'] . "</td>";
echo "<td>".$row['Tel'] . "</td>";
echo "<td>".$row['EMail'] . "</td>";
#This will redirect the user to the appointselect page after they have selected a customer
echo "<td><a href='appointselect.php?id=".$row['CustomerID']."' class='btn btn-info'>Select</a></td>";
echo "</tr>";
echo "</form>"; 
} ?>
</table>
<?php }else{echo "<br><br>No Record Found";}
include 'footer.php';?></div>



