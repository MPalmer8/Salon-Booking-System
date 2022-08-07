<?php
require_once 'connect.php';
require_once 'header.php';
require_once 'staffmenu.php';
session_start(); 
if($_SESSION["StaffID"]){echo "";}
else{header("Location:home.php");}
?>
<div class="container">
<?php
#This will validate the fields before updating the appointment details on the database
$message = '';
$validated = '';
#This will check if the TreatmentID is an integer
if(isset($_POST['update'])){
  if(!preg_match("/^[0-9]*$/",$_POST["TreatmentID"])) {
    $message = "The Treatment ID can only be a number";
    $validated = "False";
  }
  else{
    #This will check if the TreatmentID actually exists on the database
    $result = mysqli_query($con,"SELECT * FROM treatment WHERE TreatmentID='" . $_POST["TreatmentID"] . "'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)){
      $AppointmentTime = $_POST['AppointmentTime'];
      $AppointmentDate = $_POST['AppointmentDate'];
      $TreatmentID = $_POST['TreatmentID'];
  
      #This will search the database for the AppointmentTime and AppointmentDate entered to see if the date and time are already taken
      $result = mysqli_query($con,"SELECT * FROM appointment WHERE AppointmentTime ='" . $AppointmentTime . "' AND AppointmentDate ='" . $AppointmentDate . "'");
      $row  = mysqli_fetch_array($result);
      if(is_array($row)){
        $message = "There is already an appointment with this date and time.";
        $validated = "False";
      }
      else{
        #This will update the appointment details in the database on the appointment table
        $sql = "UPDATE appointment SET AppointmentTime='{$AppointmentTime}', AppointmentDate = '{$AppointmentDate}',
        TreatmentID = '{$TreatmentID}' WHERE AppointmentID=" . $_POST['AppointmentID'];
        if( $con->query($sql) === TRUE){
          $message = "Successfully updated appointment";
          $validated = "True";
        }
        else{
          $message = "Error: failed to update appointment";
          $validated = "False";
        }
      }
    }
    else{
      $message = "That Treatment ID doesn't exist.";
      $validated = "False";
    }
  }
}

#This will display the current appointment details in the fields so the user can edit them
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$sql = "SELECT * FROM appointment WHERE AppointmentID={$id}";
$result = $con->query($sql);
if($result->num_rows < 1){
header('Location: index.php');
exit;
}
$row = $result->fetch_assoc();
?>
<div class="row">
<div class="col-md-6 col-md-offset-3">
<div class="box">
<link rel="stylesheet" type = "text/css" href="css/style.css">
<div class="book-container">
    <div>
        <h3 align="center"><i class="glyphicon glyphicon-plus"></i>&nbsp;MODIFY Appointment</h3>
        <form action="" method="POST" align="center">
        <input type="hidden" value="<?php echo $row['AppointmentID']; ?>" name="AppointmentID">

        <label for="TreatmentID">Treatment ID:</label><br>
        <input type="integer" id="TreatmentID" name="TreatmentID" value="<?php echo $row['TreatmentID']; ?>" class="form-control"><br>
        <label for="AppointmentDate">Date:</label><br>
        <input type="date" name="AppointmentDate" id="AppointmentDate" value="<?php echo $row['AppointmentDate']; ?>" class="form-control"><br>
        <label for="AppointmentTime">Time:</label><br>
        <input type="time" name="AppointmentTime" id="AppointmentTime" value="<?php echo $row['AppointmentTime']; ?>" class="form-control"><br>
        <br>
        <input type="submit" name="update" class="btn btn-success" value="Update">
        </form>
        <br><br><br><br>
        <?php
        #These will display messages that are either alerting the user of it being successful or non-successful
        if($message != ''){
          if($validated == "False"){
            ?><div class = "validation"><?php
            echo $message;
            ?></div><?php
          }
          else{
            ?><div class = "validated"><?php
            echo $message;
            ?></div><?php
          }
        }
         ?>
    </div>
    <div>
        <?php 
        echo "<div class='container'>";
        #This will select all of the information from the treatment table and output it in a table format
        $sql = "SELECT * FROM treatment";
        $result = $con->query($sql);
        if( $result->num_rows > 0) { ?>
        <html>
        <body>
        <div class="allaccountstable" align="center">
        <h2>List of all Treatments</h2>
        <table class="table table-bordered table-striped">
        <tr>
        <td>TreatmentID</td>
        <td>TreatmentName</td>
        <td>Cost</td>
        <td>Description</td></tr>
        <?php
        while( $row = $result->fetch_assoc()){
        echo "<form action='' method='POST'>"; 
        echo "<input type='hidden' value='". $row['TreatmentID']."' name='TreatmentID' />"; 
        echo "<tr>";
        echo "<td>".$row['TreatmentID'] . "</td>";
        echo "<td>".$row['TreatmentName'] . "</td>";
        echo "<td>".$row['Cost'] . "</td>";
        echo "<td>".$row['TreatmentDescription'] . "</td>";
        echo "</tr>";
        echo "</form>"; }?>
        </table>
        </div>
        <?php
        }else{echo "<br><br>No Record Found";}?><br>
    </div>
</div></div></div></div></div>
<?php
require_once 'footer.php';