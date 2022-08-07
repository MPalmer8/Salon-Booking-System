<?php
require_once 'connect.php'; require_once 'header.php';  require_once 'customermenu.php';
session_start(); 
?><br><?php
if($_SESSION["CustomerID"]){echo "";}else{header("Location:home.php");} 
$CustomerID = $_SESSION["CustomerID"];
echo "<div class='container'>";
#This will select the appointment information relating to the user that is logged in
$sql = "SELECT * FROM Appointment Where CustomerID=$CustomerID";
$result = $con->query($sql);
if( $result->num_rows > 0){
?>
<h2 align="center">List of Appointments</h2>
<html>
<body>
<table class="table table-bordered table-striped" align="center">
<tr>
<td>Treatment</td>
<td>AppointmentDate</td>
<td>AppointmentTime</td>
<td width="70px">Delete</td>
<td width="70px">EDIT</td>
</tr>
<?php
#This will output the appointment information relating to the user logged in and output it in a table format 
while( $row = $result->fetch_assoc()){
echo "<form action='' method='POST'>"; 
echo "<input type='hidden' value='". $row['AppointmentID']."' name='AppointmentID' />"; 
echo "<tr>";
echo "<td>".$row['TreatmentID'] . "</td>";
echo "<td>".$row['AppointmentDate'] . "</td>";
echo "<td>".$row['AppointmentTime'] . "</td>";
echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' /></td>";
echo "<td><a href='appointcedit.php?id=".$row['AppointmentID']."' class='btn btn-info'>Edit</a></td>";
echo "</tr>";
echo "</form>"; 
}
?>
</table>

<?php
}
else{echo "No Record Found";}
?>
<br>
<?php
#This will delete the appointment from the database that is selected to be deleted
if( isset($_POST['delete'])){
  $sql = "DELETE FROM Appointment WHERE AppointmentID=" . $_POST['AppointmentID'];
  if($con->query($sql) === TRUE){
    ?><br> <div class="alert"><?php
    echo "Successfully deleted appointment";}
    header("Location:cappointments.php");
    ?></div><?php
  }
?>
<br><br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php';?>
</div>
</body>