<?php
require_once 'connect.php'; require_once 'header.php'; require_once 'staffmenu.php';
error_reporting(E_ERROR | E_PARSE);
session_start(); 
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if($_SESSION["StaffID"]==$id){echo "";}else{header("Location:home.php");} ?>
<div class="container">
<h3 align="center"><i class="glyphicon glyphicon-plus"></i>&nbsp;RESET Password</h3>
<form action="" method="POST" align="center">
<label for="Passcode">Password:</label>
<br><input type="password" id="Passcode" name="Passcode" class="form-control"><br>
<label for="Passcode2">Confirm Password:</label>
<br><input type="password" id="Passcode2" name="Passcode2" class="form-control"><br><br>
<input type="submit" name="update" class="btn btn-success" value="Update"></form>
</div> <?php $passcode = $_POST['Passcode'];
$confirmpass = $_POST['Passcode2'];
#This will check if the passwork is correctly validated
$passwordval = '';
$passwordreason = '';
if (empty($_POST['Passcode'])){$passwordval = "False";
    $passwordreason = "Please fill out the required fields";
}
elseif(!preg_match("#[a-z]+#",$_POST['Passcode'])) {
    $passwordreason = "Your Password Must Contain At Least 1 Lowercase Letter!";
    $passwordval = "False";
}
elseif(strlen($_POST['Passcode']) < '8') {
    $passwordreason = "Your password must contain at least 8 characters";
    $passwordval = "False";
}
elseif(!preg_match("#[0-9]+#",$_POST['Passcode'])) {
    $passwordreason = "Your Password Must Contain At Least 1 Number!";
    $passwordval = "False";
}
elseif(!preg_match("#[A-Z]+#",$_POST['Passcode'])) {
    $passwordreason = "Your Password Must Contain At Least 1 Capital Letter!";
    $passwordval = "False";
}else{
    $passwordval = "True";
}

#This will check if the two password fields match
$matchpass = '';
if($confirmpass === $passcode){
    $matchpass = "True";
}else{
    $matchpass = "False";
}

if(isset($_POST['update'])){
    if($passwordval == "False"){
        ?><div class="validation"><?php
        echo $passwordreason;
        ?></div><?php
    }
    else{
        if($matchpass == "False"){
            ?><div class="validation"><?php
            echo "The passwords do not match!";
            ?></div><?php
        }
        else{
            #This will update the passcode for the staff member
            $hashed_passcode = password_hash($passcode, PASSWORD_BCRYPT);
            $sql = "UPDATE Staff SET Passcode = '$hashed_passcode' WHERE StaffID= '$id'";
            if($con->query($sql) === TRUE){
                echo "<div class='validated'>Successfully updated password</div>";
            }
            else{
                echo "<div class='validation'>Error: There was an error while resetting the password</div>";
            }
        }
    }
}
?>
<br><br><br><br><br><br><br><br><br><br><br>
<?php
require_once 'footer.php';