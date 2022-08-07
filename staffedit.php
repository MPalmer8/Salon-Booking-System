<?php
require_once 'connect.php';
require_once 'header.php';
require_once 'staffmenu.php';
error_reporting(E_ERROR | E_PARSE);
session_start(); 
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if($_SESSION["StaffID"]==$id){echo "";}
else{header("Location:home.php");} ?>
<div class="container">
<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$sql = "SELECT * FROM Staff WHERE StaffID={$id}";
$result = $con->query($sql);
if($result->num_rows < 1){
header('Location: index.php');
exit;}
$row = $result->fetch_assoc(); ?>
<div class="row">
<div class="col-md-6 col-md-offset-3">
<div class="box">
<h3 align="center"><i class="glyphicon glyphicon-plus"></i>&nbsp;MODIFY User</h3>
<form action="" method="POST" align="center">
<input type="hidden" value="<?php echo $row['StaffID']; ?>" name="StaffID">

<label for="StaffFirstName">Firstname:</label><br>
<input type="text" id="StaffFirstName" name="StaffFirstName" value="<?php echo $row['StaffFirstName']; ?>" class="form-control"><br>
<label for="StaffLastName">Lastname:</label><br>
<input type="text" name="StaffLastName" id="StaffLastName" value="<?php echo $row['StaffLastName']; ?>" class="form-control"><br>
<label for="StaffUsername">Username:</label><br>
<input type="text" name="StaffUsername" id="StaffUsername" value="<?php echo $row['StaffUsername']; ?>" class="form-control"><br>
<br>
<input type="submit" name="update" class="btn btn-success" value="Update">
</form>
</div>
</div>
</div>
</div>
<?php
// Checks if the username is validated by checking if it contains any special characters and if its in the database already
$usernameval = '';
$usernamereason = '';
if(empty($_POST['StaffUsername'])){$usernameval = "False";} 
elseif(!preg_match("/^[a-zA-Z-._0-9]*$/",$_POST["StaffUsername"])) {
    $usernamereason = "Username format error - Special Characters are not allowed";
    $usernameval = "False";
}else{
    $result = mysqli_query($con,"SELECT * FROM staff WHERE StaffUsername='" . $_POST["StaffUsername"] . "'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)){
        $usernameval = "False";
        $usernamereason = "Username already in use, please use a different Username";
        if($row["StaffUsername"] == $_POST["StaffUsername"]){
            $usernameval = "True";
            $usernamereason = '';
        }
    }else{$usernameval = "True";}

}

// This checks if the firstname is validated by checking if it contains any special characters
$firstnameval = '';
$firstnamereason = '';
if(!preg_match("/^[a-zA-Z-]*$/",$_POST["StaffFirstName"])) {
    $firstnamereason = "Firstname format error - Special characters are not allowed";
    $firstnameval = "False";
}
elseif(empty($_POST['StaffFirstName'])){$firstnameval = "False";}
else{
    $firstnameval = "True";
}

// This checks if the lastname is validated by checking if it contains any special characters
$lastnameval = '';
$lastnamereason = '';
if(!preg_match("/^[a-zA-Z-]*$/",$_POST["StaffLastName"])) {
    $lastnamereason = "Lastname format error - Special characters are not allowed";
    $lastnameval = "False";
}
elseif(empty($_POST['StaffLastName'])){$lastnameval = "False";}
else{
    $lastnameval = "True";
}

// This checks if any of the fields are empty
$emptyval = "";
$emptymsg = "";
if((empty($_POST['StaffFirstName'])) or (empty($_POST['StaffLastName'])) or (empty($_POST['StaffUsername']))){
    $emptyval = "False"; 
    $emptymsg = "Please fill out all the required fields";
}else{
    $emptyval = "True";
}
#This code will echo the reasons on which why the fields are not validated if any of the validation variables are false
if(isset($_POST['update'])){
if(($firstnameval == "False") or ($lastnameval == "False") or ($usernameval == "False") or ($emptyval == "False")){
    ?><div class="validation"><?php
    if($emptymsg!='') { echo $emptymsg, "<br>"; }; 
    if($firstnamereason!='') { echo $firstnamereason, "<br>" ; }; 
    if($lastnamereason!='') { echo $lastnamereason, "<br>"; }; 
    if($usernamereason!='') { echo $usernamereason, "<br>"; };
    ?></div><?php
}
#This will update the staff member's details in the database in the staff table
else{
    $firstname = $_POST['StaffFirstName'];
    $lastname = $_POST['StaffLastName'];
    $username = $_POST['StaffUsername'];
    $sql = "UPDATE Staff SET StaffFirstName='{$firstname}', StaffLastName = '{$lastname}', StaffUsername = '{$username}' 
    WHERE StaffID=" . $_POST['StaffID'];
    if( $con->query($sql) === TRUE){
        ?><div class="validated"><?php
        echo "Successfully updated user";
        ?></div><?php
    }
    else{
        ?><div class="validation"><?php
        echo "Error: There was an error while updating user info";
        ?></div><?php
    }

}
}
?>
<br><br><br><br><br><br><br><br><br>
<?php
require_once 'footer.php';


