<?php
session_start(); 
if($_SESSION["CustomerID"]){echo "";}else{header("Location:home.php");}
require_once 'connect.php'; require_once 'header.php';  require_once 'customermenu.php';
$CustomerID = $_SESSION["CustomerID"];
echo "<div class='container'>";
#This will select the information of the customer that is logged in from the database
$sql = "SELECT * FROM Customer  Where CustomerID = $CustomerID ";
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
<td>Tel</td>
<td>E-Mail</td>
<td>Gender</td>
<td width="70px">EDIT</td>
<td>Reset Password</td>
</tr>
<?php
#This will output the user's information into the table format on the webpage
while( $row = $result->fetch_assoc()){
echo "<form action='' method='POST'>"; 
echo "<input type='hidden' value='". $row['CustomerID']."' name='CustomerID' />"; 
echo "<tr>";
echo "<td>".$row['FirstName'] . "</td>";
echo "<td>".$row['LastName'] . "</td>";
echo "<td>".$row['Username'] . "</td>";
echo "<td>".$row['Tel'] . "</td>";
echo "<td>".$row['EMail'] . "</td>";
echo "<td>".$row['Gender'] . "</td>";
echo "<td><a href='cedit.php?id=".$row['CustomerID']."' class='btn btn-info'>Edit</a></td>";
echo "<td><a href='passresetcust.php?id=".$row['CustomerID']."' class='btn btn-info'>Reset</a></td>";
echo "</tr>";
echo "</form>";  }
?>
</table>
<?php }
else{echo "<br><br>No Record Found";}
?><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php';?>
</div>

