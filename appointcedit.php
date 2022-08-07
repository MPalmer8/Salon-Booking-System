<?php
require_once 'connect.php'; require_once 'header.php'; require_once 'customermenu.php';
error_reporting(E_ERROR | E_PARSE);
session_start(); 
if($_SESSION["CustomerID"]){echo "";}
else{header("Location:home.php");}
?>
<div class="container">
<?php
$message = '';
$validated = '';
if(isset($_POST['update'])){
  #This will check if the TreatmentID is an integer
  if(!preg_match("/^[0-9]*$/",$_POST["TreatmentID"])) {
    $message = "The Treatment ID can only be a number";
    $validated = "False";
  }
  else{
    #This will check if the TreatmentID exists on the database
    $result = mysqli_query($con,"SELECT * FROM treatment WHERE TreatmentID='" . $_POST["TreatmentID"] . "'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)){
      $AppointmentTime = $_POST['AppointmentTime'];
      $AppointmentDate = $_POST['AppointmentDate'];
      $TreatmentID = $_POST['TreatmentID'];
      $customerID = $_SESSION['CustomerID'];
      #This checks if there is already an appointment with the date and time selected
      $result = mysqli_query($con,"SELECT * FROM appointment WHERE AppointmentTime ='" . $AppointmentTime . "' AND AppointmentDate ='" . $AppointmentDate . "'");
      $row  = mysqli_fetch_array($result);
      if(($row["AppointmentTime"] == $AppointmentTime) and ($row["AppointmentDate"] == $AppointmentDate)){
        #This updates the appointment details in the database
        $sql = "UPDATE appointment SET AppointmentTime='{$AppointmentTime}', AppointmentDate = '{$AppointmentDate}',
        TreatmentID = '{$TreatmentID}' WHERE AppointmentID=" . $_POST['AppointmentID'];
        if( $con->query($sql) === TRUE){
          $message = "Successfully updated appointment";
          $validated = "True";
          }
        else{
          $message = "Error: failed to update appointment";
          $validated = "False";
          }}
      elseif(is_array($row)){
        $message = "There is already an appointment with this date and time.";
        $validated = "False";
      }
      else{
        #This updates the appointment details in the database
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

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
#This selects the appointment information regarding to the appointment that the user is editting from the database
$sql = "SELECT * FROM appointment WHERE AppointmentID={$id}";
$result = $con->query($sql);
if($result->num_rows < 1){
header('Location: index.php');
exit; }
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
        <?php #This outputs the appointment information that the customer is currently editting in the fields. ?>
        <label for="TreatmentID">Treatment ID:</label><br>
        <input type="integer" id="TreatmentID" name="TreatmentID" value="<?php echo $row['TreatmentID']; ?>" class="form-control"><br>
        <label for="AppointmentDate">Date:</label><br>
        <input type="date" name="AppointmentDate" id="AppointmentDate" value="<?php echo $row['AppointmentDate']; ?>" class="form-control"><br>
        <label for="AppointmentTime">Time:</label><br>
        <input type="time" name="AppointmentTime" id="AppointmentTime" value="<?php echo $row['AppointmentTime']; ?>" class="form-control" min="09:00" max="18:00" required step="3600"><br>
        <br>
        <input type="submit" name="update" class="btn btn-success" value="Update">
        </form>
        <br><br><br><br>
        <?php
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
        <br>
    </div>
    <div>
        <?php 
        echo "<div class='container'>";
        #This selects all of the information from the treatment table on the database
        $sql = "SELECT * FROM treatment";
        $result = $con->query($sql);
        if( $result->num_rows > 0){
        ?>
        <html>
        <body>
        <div class="allaccountstable" align="center">
        <h2>List of all Treatments</h2>
        <table class="table table-bordered table-striped">
        <tr>
        <td>TreatmentID</td>
        <td>TreatmentName</td>
        <td>Cost</td>
        <td>Description</td>
        </tr>
        <?php
        #This displays all of the treatments currently in the treatments table on the database
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
        <?php
        }else{echo "<br><br>No Record Found";}
        ?>
        <br>
    </div>
</div>
</div>
</div>
</div>
</div>
<?php
require_once 'footer.php';

