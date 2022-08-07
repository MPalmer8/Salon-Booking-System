<link rel="stylesheet" type = "text/css" href="css/style.css">
<?php
// This code checks if a staff member if logged in 
session_start(); 
if($_SESSION["StaffID"]){echo "";}else{header("Location:home.php");}
require_once 'connect.php'; require_once 'header.php';  require_once 'staffmenu.php';
?>
<html>
<head>
<style>
</style>
</head>
<body>
 
<div class="overview-container-one">
  <div class="overview-item-one">
      <?php 
      #This will count the amount of customers that are currently on the system
      $sql="SELECT count(CustomerID) AS total FROM customer";
      $result = mysqli_query($con, $sql);
      $values = mysqli_fetch_assoc($result);
      $customer_rows = $values['total'];
      ?>
      <table class="overview table" align="Center">
          <tr>
              <th> Total Customer Accounts </th>
          </tr>
          <tr>
              <td> <?php echo $customer_rows; ?> </td>
          </tr>
      </table>
  </div>
  <div class="overview-item-one">
      <?php 
      #This will count the amount of staff members that are currently on the system
      $sql="SELECT count(StaffID) AS total FROM staff";
      $result = mysqli_query($con, $sql);
      $values = mysqli_fetch_assoc($result);
      $staff_rows = $values['total'];
      ?>
      <table class="overview table" align="Center">
          <tr>
              <th> Total Staff Accounts </th>
          </tr>
          <tr>
              <td> <?php echo $staff_rows; ?> </td>
          </tr>
      </table>
  </div>
  <div class="overview-item-one" >
      <?php #This will show the total amount of accounts that is currently on the system
      $total_accounts = $customer_rows + $staff_rows; ?>
       <table class="overview table" align="Center">
          <tr>
              <th> Total Accounts </th>
          </tr>
          <tr>
              <td> <?php echo $total_accounts; ?> </td>
          </tr>
      </table>
  </div>
  <div class="overview-item-one">
        <?php
        #This will display the amount of customers that have their gender set to "M"
        $malecount = 0; 
        $sql = "SELECT * FROM customer WHERE Gender = 'M' ";
        $result = $con->query($sql);
        if( $result->num_rows > 0){ 
            while( $row = $result->fetch_assoc()){
            $malecount = $malecount + 1;
            }
        }else{$malecount=0;}
      ?>
        <table class="overview table" align="Center">
          <tr>
              <th> Total Males </th>
          </tr>
          <tr>
              <td> <?php echo $malecount; ?> </td>
          </tr>
      </table>
  </div>

  <div class="overview-item-one">
        <?php
        #This will display the amount of customers that have their gender set to "F"
        $femalecount = 0; 
        $sql = "SELECT * FROM customer WHERE Gender = 'F' ";
        $result = $con->query($sql);
        if( $result->num_rows > 0){ 
            while( $row = $result->fetch_assoc()){
            $femalecount = $femalecount + 1;
            }
        }else{$femalecount=0;}
      ?>
        <table class="overview table" align="Center">
          <tr>
              <th> Total Females </th>
          </tr>
          <tr>
              <td> <?php echo $femalecount; ?> </td>
          </tr>
      </table>
  </div>

  <div class="overview-item-one">
        <?php
        #This will display the amount of customers that have their gender set to "Other"
        $othercount = 0; 
        $sql = "SELECT * FROM customer WHERE Gender = 'Other' ";
        $result = $con->query($sql);
        if( $result->num_rows > 0){ 
            while( $row = $result->fetch_assoc()){
            $othercount = $othercount + 1;
            }
        }else{$othercount=0;}
      ?>
        <table class="overview table" align="Center">
          <tr>
              <th> Total Other </th>
          </tr>
          <tr>
              <td> <?php echo $othercount; ?> </td>
          </tr>
      </table>
  </div>

  <div class="overview-item-one">
      <?php  #This will count the amount of treatments on the system
      $sql="SELECT count(TreatmentID) AS total FROM treatment";
      $result = mysqli_query($con, $sql);
      $values = mysqli_fetch_assoc($result);
      $treatment_rows = $values['total'];
      ?>
      <table class="overview table" align="Center">
          <tr>
              <th> Total Treatments on System </th>
          </tr>
          <tr>
              <td> <?php echo $treatment_rows; ?> </td>
          </tr>
      </table>
  </div>

  <div class="overview-item-one">
      <?php #This will count the amount of appointments that are currently booked
      $sql="SELECT count(AppointmentID) AS total FROM appointment";
      $result = mysqli_query($con, $sql);
      $values = mysqli_fetch_assoc($result);
      $appointment_rows = $values['total'];
      ?>
      <table class="overview table" align="Center">
          <tr>
              <th> Total Appointments Booked </th>
          </tr>
          <tr>
              <td> <?php echo $appointment_rows; ?> </td>
          </tr>
      </table>
  </div>

  <div class="overview-item-one">
      <?php #This will calculate the amount of revenue that is made from the current booked appointments
      $sql="SELECT Sum(Cost) AS sum FROM Appointment INNER JOIN treatment USING(TreatmentID)";
      $result = $con->query($sql);
      if( $result->num_rows > 0){ 
          while( $row = $result->fetch_assoc()){
          $costtotal ="£"." ".$row['sum'];
          }
      }else{$costtotal=0;}

      ?>
      <table class="overview table" align="Center">
          <tr>
              <th> Total Revenue </th>
          </tr>
          <tr>
              <td> <?php echo $costtotal; ?> </td>
          </tr>
      </table>
  </div>

</div>
<?php include 'footer.php';?>
</body>
</html>