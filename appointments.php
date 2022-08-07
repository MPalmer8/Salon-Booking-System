<?php
require_once 'connect.php'; require_once 'header.php';  require_once 'staffmenu.php';
session_start(); 
if($_SESSION["StaffID"]){echo "";}else{header("Location:home.php");} 
echo "<div class='container'>";
?><div class="display-container">
<div>
  <?php
  #This will display all of the appointments with the names of the customer's that booked them also included
  $sql = "SELECT * FROM Appointment INNER JOIN Customer ON Appointment.CustomerID = Customer.CustomerID";
  $result = $con->query($sql);
  if( $result->num_rows > 0){ ?>
  <h2>List of all Appointments</h2>
  <html>
  <body>
  <div class="tabletest">
  <table class="table table-bordered table-striped">
  <tr>
  <td>Treatment</td>
  <td>Firstname</td>
  <td>Lastname</td>
  <td>AppointmentDate</td>
  <td>AppointmentTime</td>
  <td width="70px">Delete</td>
  <td width="70px">EDIT</td>
  </tr>
  <?php
  while( $row = $result->fetch_assoc()){
    echo "<form action='' method='POST'>"; //added
    echo "<input type='hidden' value='". $row['AppointmentID']."' name='AppointmentID' />"; //added
    echo "<tr>";
    echo "<td>".$row['TreatmentID'] . "</td>";
    echo "<td>".$row['FirstName'] . "</td>";
    echo "<td>".$row['LastName'] . "</td>";
    echo "<td>".$row['AppointmentDate'] . "</td>";
    echo "<td>".$row['AppointmentTime'] . "</td>";
    echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' /></td>";
    echo "<td><a href='appointsedit.php?id=".$row['AppointmentID']."' class='btn btn-info'>Edit</a></td>";
    echo "</tr>";
    echo "</form>"; //added
  }
  ?>
  </table>
  </div>
  <?php }
  else{echo "<br><br>No Record Found";} ?>
  <br>
  <?php
  if( isset($_POST['delete'])){
    $sql = "DELETE FROM Appointment WHERE AppointmentID=" . $_POST['AppointmentID'];
    if($con->query($sql) === TRUE){
      echo "<br><div class='alert'>Successfully deleted appointment</div>";}
  }
  ?>
  <br><br>
  <a href="selectcustomer.php">Create an Appointment</a>
</div> 
<div>
  <div class="searchfunction">
  <h2>Search</h2>
  <form method="post">
  <label for="searchoption">Choose a category to search for:</label>
  <select name="searchoption" id="searchoption">
    <option value="TreatmentID">TreatmentID</option>
    <option value="FirstName">Firstname</option>
    <option value="LastName">Lastname</option>
    <option value="AppointmentDate">Appointment Date</option>
    <option value="AppointmentTime">Appointment Time</option>
  </select>
  <br><br>
  <input type = "text" name = "search" placeholder="Search...">
  <input type = "submit" name="submit">
  </form>
  <?php
  #This is a search function that will search through the appointment table for the data that the user wants to search for
  if(isset($_POST["submit"])){
    $str = $_POST["search"];
    $searchoption = $_POST["searchoption"];
    $sql = "SELECT * FROM Appointment INNER JOIN Customer USING(CustomerID) WHERE $searchoption LIKE '%$str%' ";
    $result = $con->query($sql);
    if($result->num_rows > 0){
      ?>
      <div class="tabletest">
      <table class="table table-bordered table-striped"><tr>
      <td>Treatment</td>
      <td>Firstname</td>
      <td>Lastname</td>
      <td>AppointmentDate</td>
      <td>AppointmentTime</td>
      </tr><?php
      while( $row = $result->fetch_assoc()){
        #This will output the information from the database into the table
        echo "<form action='' method='POST'>"; 
        echo "<input type='hidden' value='". $row['AppointmentID']."' name='AppointmentID' />"; 
        echo "<tr>";
        echo "<td>".$row['TreatmentID'] . "</td>";
        echo "<td>".$row['FirstName'] . "</td>";
        echo "<td>".$row['LastName'] . "</td>";
        echo "<td>".$row['AppointmentDate'] . "</td>";
        echo "<td>".$row['AppointmentTime'] . "</td>";
        echo "</tr>";
        echo "</form>"; }
      ?>
      </table></div>
      <?php
      }else{echo "<br><br>No Record Found";}
      ?>
      <?php
    } ?>
</div></div></div>
<br><br>
<?php include 'footer.php';?>
</body>