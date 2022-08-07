<?php
require_once 'connect.php'; require_once 'header.php'; require_once 'customermenu.php';
?>
<?php session_start(); ?>
<?php if($_SESSION["CustomerID"]){echo "";}else{header("Location:home.php");} ?>
<hmtl>
<head> 
<title> Create an appointment </title>
</head> 
<body>
<link rel="stylesheet" type = "text/css" href="css/style.css">
<div class="book-container">
    <div>
      <h3 align="center"><i class="glyphicon glyphicon-plus"></i>&nbsp;BOOK Appointment</h3>
        <form action="" method="POST" align="center">
        <label for="TreatID">Treatment ID:</label>
        <br><input type="integer" id="TreatID" name="TreatID" class="form-control"><br>
        <label for="TreatmentDate">Date:</label>
        <br><input type="date" id="TreatmentDate" name="TreatmentDate" class="form-control" required><br>
        <label for="TreatmentTime">Time:</label>
        <br><input type="time" id="TreatmentTime" name="TreatmentTime" class="form-control" min="09:00" max="18:00" required step="3600"><br>
        <p>Disclaimer: All Appointments will last an hour, Please choose a time by the hour (e.g. 13:00)</p>

        <br><input type="submit" name="submit">
        <input type="reset"><br><br>
        <?php
        if(isset($_POST['submit'])){
          #This checks if the TreatmentID is an integer
          if(!preg_match("/^[0-9]*$/",$_POST["TreatID"])) {
            echo "<div class='validation'>The Treatment ID can only be a number</div>";}
          else{
            #This checks if the TreatmentID exists on the database
            $result = mysqli_query($con,"SELECT * FROM treatment WHERE TreatmentID='" . $_POST["TreatID"] . "'");
            $row  = mysqli_fetch_array($result);
            if(is_array($row)){
              $time = $_POST['TreatmentTime'];
              $date = $_POST['TreatmentDate'];
              $treatmentID = $_POST['TreatID'];
              $customerID = $_SESSION['CustomerID'];
              #This checks if there is an appointment with the date and time selected
              $result = mysqli_query($con,"SELECT * FROM appointment WHERE AppointmentTime ='" . $time . "' AND AppointmentDate ='" . $date . "'");
              $row  = mysqli_fetch_array($result);
              if(is_array($row)){
                echo "<div class='validation'>There is already an appointment with this date and time.</div>";}
              else{
                #This adds the appointment details to the appointment table on the database
                $sql = "INSERT INTO appointment(AppointmentTime,AppointmentDate,CustomerID,TreatmentID) VALUES('$time','$date','$customerID','$treatmentID')";
                if( $con->query($sql) === TRUE){
                  echo "<div class='validated'>Successfully booked new appointment</div>";
                } 
                else{
                  echo "<div class='validation'>Error: failed to book new appointment</div>";
                }
              }
            }
           else{echo "<div class='validation'>That Treatment ID doesn't exist.</div>";}
}
}

?>
    </div>
    <div>  
        <?php 
        echo "<div class='container'>";
        #This selects all of the information on the treatment table in the database
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
        #This outputs the information that is in the treatment table in the database
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
        }
        else{echo "<br><br>No Record Found";}
        ?>
        </div>
        <br>
    </div>
</div>
<?php include 'footer.php';?>
</body> 
</hmtl>




