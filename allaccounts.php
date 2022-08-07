<link rel="stylesheet" type = "text/css" href="css/style.css"><?php
// This code checks if a staff member if logged in 
session_start(); 
if($_SESSION["StaffID"]){echo "";}else{header("Location:home.php");}
require_once 'connect.php'; require_once 'header.php';  require_once 'staffmenu.php';
echo "<div class='container'>";
?>
<div class="display-container">
<div>
  <?php
  // This code selects all the information from the customer table and outputs it using a table
  $sql = "SELECT * FROM Customer";
  $result = $con->query($sql);
  if( $result->num_rows > 0){ ?>
  <h2>List of all Customers</h2>
  <html>
  <body>
  <div class="allaccountstable">
  <table class="table table-bordered table-striped">
  <tr>
  <td>Firstname</td>
  <td>Lastname</td>
  <td>Username</td>
  <td>Tel</td>
  <td>E-Mail</td>
  <td>Gender</td>
  <td width="70px">Delete</td>
  <td width="70px">EDIT</td>
  <td>Password Reset</td>
  </tr>
  <?php
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
    echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' /></td>";
    echo "<td><a href='edit.php?id=".$row['CustomerID']."' class='btn btn-info'>Edit</a></td>";
    echo "<td><a href='passreset.php?id=".$row['CustomerID']."' class='btn btn-info'>Reset</a></td>";
    echo "</tr>";
    echo "</form>"; 
  }
  ?>
  <br>
  </table>
  </div>
  <?php
  }
  else{echo "<br><br>No Record Found";}
  ?>
  <br>
  <?php
  // This code is used to delete the customer selected from the database if the delete button is pressed
  if( isset($_POST['delete'])){
    $sql = "DELETE FROM Customer WHERE CustomerID=" . $_POST['CustomerID'];
    if($con->query($sql) === TRUE){echo "<div class='alert'>Successfully deleted user</div>";}
  }
?></div><?php
// This code allows the user to select a field they want to search through on the table and enter information they are looking for
?>
<div>
  <div class="searchfunction">
  <h2>Search</h2>
  <form method="post">
  <label for="searchoption">Choose a category to search for:</label>
  <select name="searchoption" id="searchoption">
    <option value="FirstName">Firstname</option>
    <option value="LastName">Lastname</option>
    <option value="Username">Username</option>
    <option value="Tel">Tel</option>
    <option value="EMail">E-Mail</option>
    <option value="Gender">Gender</option>
  </select>
  <br><br>
  <input type = "text" name = "search" placeholder="Search...">
  <input type = "submit" name="submit" >
  </form>
  <?php
  // This code displays the row from the customer table if the information can be found
  if(isset($_POST["submit"])){
    $str = $_POST["search"];
    $searchoption = $_POST["searchoption"];
    $sql = "SELECT * FROM customer WHERE $searchoption LIKE '%$str%' ";
    $result = $con->query($sql);
    if( $result->num_rows > 0){
      ?>
      <div class="tabletest">
      <table class="table table-bordered table-striped">
      <tr>
      <td>Firstname</td>
      <td>Lastname</td>
      <td>Username</td>
      <td>Tel</td>
      <td>E-Mail</td>
      <td>Gender</td>
      </tr>
      <?php
      while( $row = $result->fetch_assoc()){
        #This will output the information from the customer table into the table format on the webpage
        echo "<form action='' method='POST'>"; //added
        echo "<input type='hidden' value='". $row['CustomerID']."' name='CustomerID' />"; //added
        echo "<tr>";
        echo "<td>".$row['FirstName'] . "</td>";
        echo "<td>".$row['LastName'] . "</td>";
        echo "<td>".$row['Username'] . "</td>";
        echo "<td>".$row['Tel'] . "</td>";
        echo "<td>".$row['EMail'] . "</td>";
        echo "<td>".$row['Gender'] . "</td>";
        echo "</tr>";
        echo "</form>"; //added
      }
      ?>
      </table></div><?php
      }
      else{echo "<br>No Record Found";}
    }
?>
</div></div></div><br><br><br><br><br><br>
<?php include 'footer.php';?>
</div>