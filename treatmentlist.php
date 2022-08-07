<link rel="stylesheet" type = "text/css" href="css/style.css">
<?php require_once 'connect.php'; require_once 'header.php';  require_once 'menu.php';
echo "<div class='container' align='center'>";
#This will select all of the information from the treatment table
$sql = "SELECT * FROM treatment";
$result = $con->query($sql);
#If the table has some contents, a table format will be created, if not, a message "No record found" will be outputted
if( $result->num_rows > 0){ ?>
<h2>List of all Treatments</h2>
<html>
<body>
<div class="allaccountstable">
<table class="table table-bordered table-striped">
<tr>
<td>Treatment ID</td>
<td>Treatment Name</td>
<td>Cost (£)</td>
<td>Description</td>
</tr>
<?php
#Whilst there are results in the table yet to be outputted, they will be outputted
while( $row = $result->fetch_assoc()){
echo "<form action='' method='POST'>"; 
echo "<input type='hidden' value='". $row['TreatmentID']."' name='TreatmentID' />"; 
echo "<tr>";
echo "<td>".$row['TreatmentID'] . "</td>";
echo "<td>".$row['TreatmentName'] . "</td>";
echo "<td>".$row['Cost'] . "</td>";
echo "<td>".$row['TreatmentDescription'] . "</td>";
echo "</tr>";
echo "</form>"; 
}
?>
</table>
</div>
<?php }else{echo "<br><br>No Record Found";}?>
</div>
<?php include 'footer.php';?>

