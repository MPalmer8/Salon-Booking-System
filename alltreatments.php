<link rel="stylesheet" type = "text/css" href="css/style.css">
<?php
session_start(); 
if($_SESSION["StaffID"]){echo "";}else{header("Location:home.php");}
require_once 'connect.php';
require_once 'header.php'; 
require_once 'staffmenu.php';
echo "<div class='container'>";
#This will select all of the information from the treatment table in the database
$sql = "SELECT * FROM treatment";
$result = $con->query($sql);
if( $result->num_rows > 0)
{
?>
<h2 align="center">List of all Treatments</h2>
<html>
<head>
</head>
<body>
<div class="allaccountstable">
<table class="table table-bordered table-striped" align="center">
<tr>
<td>TreatmentID</td>
<td>TreatmentName</td>
<td>Cost (£)</td>
<td>Description</td>
<td width="70px">Delete</td>
<td width="70px">EDIT</td>
</tr>
<?php
#This will output all of the information into a table format on the webpage
while( $row = $result->fetch_assoc()){
echo "<form action='' method='POST'>"; 
echo "<input type='hidden' value='". $row['TreatmentID']."' name='TreatmentID' />"; 
echo "<tr>";
echo "<td>".$row['TreatmentID'] . "</td>";
echo "<td>".$row['TreatmentName'] . "</td>";
echo "<td>".$row['Cost'] . "</td>";
echo "<td>".$row['TreatmentDescription'] . "</td>";
echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' /></td>";
echo "<td><a href='treatmentedit.php?id=".$row['TreatmentID']."' class='btn btn-info'>Edit</a></td>";
echo "</tr>";
echo "</form>"; 
}
?>
</table>
<br>
</div>
<?php
}
else{echo "<br><br>No Record Found";}
?>
<br>
<?php
#This will delete the treatment chosen if the delete function is used
if( isset($_POST['delete'])){
$sql = "DELETE FROM treatment WHERE TreatmentID=" . $_POST['TreatmentID'];
if($con->query($sql) === TRUE){
echo "<br><div class='alert'>Successfully deleted treatment</div>";
}
}
?>
<br><a href="addtreatment.php">Add a Treatment</a>
<?php include 'footer.php';?>
</div>
