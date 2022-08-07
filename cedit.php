<?php
require_once 'connect.php';
require_once 'header.php';
require_once 'customermenu.php';
error_reporting(E_ERROR | E_PARSE);
session_start(); 
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if($_SESSION["CustomerID"]==$id){echo "";}
else{header("Location:home.php");}
?>
<div class="container">
<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$sql = "SELECT * FROM Customer WHERE CustomerID={$id}";
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
<h3 align="center"><i class="glyphicon glyphicon-plus"></i>&nbsp;MODIFY User</h3>
<form action="" method="POST" align="center">
<input type="hidden" value="<?php echo $row['CustomerID']; ?>" name="CustomerID">

<label for="FirstName">Firstname:</label><br>
<input type="text" id="FirstName" name="FirstName" value="<?php echo $row['FirstName']; ?>" class="form-control"><br>
<label for="LastName">Lastname:</label><br>
<input type="text" name="LastName" id="LastName" value="<?php echo $row['LastName']; ?>" class="form-control"><br>
<label for="Username">Username:</label><br>
<input type="text" name="Username" id="Username" value="<?php echo $row['Username']; ?>" class="form-control"><br>
<label for="Tel">Telephone:</label><br>
<input type="text" name="Tel" id="Tel" value="<?php echo $row['Tel']; ?>" class="form-control"><br>
<label for="EMail">E-Mail:</label><br>
<input type="text" name="EMail" id="EMail" value="<?php echo $row['EMail']; ?>" class="form-control"><br><br>

<?php if($row["Gender"] == "M") {?>
<input type="radio" id="male" name="gender" value="M" checked="True">
<label for="male">Male</label>
<input type="radio" id="female" name="gender" value="F">
<label for="female">Female</label>
<input type="radio" id="other" name="gender" value="Other">
<label for="other">Other</label><br>
<?php } ?>

<?php if($row["Gender"] == "F") {?>
<input type="radio" id="male" name="gender" value="M">
<label for="male">Male</label>
<input type="radio" id="female" name="gender" value="F" checked="True">
<label for="female">Female</label>
<input type="radio" id="other" name="gender" value="Other">
<label for="other">Other</label><br>
<?php } ?>

<?php if($row["Gender"] == "Other") {?>
<input type="radio" id="male" name="gender" value="M" checked="True">
<label for="male">Male</label>
<input type="radio" id="female" name="gender" value="F">
<label for="female">Female</label>
<input type="radio" id="other" name="gender" value="Other" checked="True">
<label for="other">Other</label><br>
<?php } ?>
<br>
<input type="submit" name="update" class="btn btn-success" value="Update">
</form>
</div>
</div>
</div>
</div>
<?php

// This checks if the email is validated by checking its format and by checking if its already in use
$emailval = '';
$emailreason = '';
$emailreason2 = '';
if(empty($_POST['EMail'])){$emailval = "False";}
elseif((!filter_var($_POST["EMail"], FILTER_VALIDATE_EMAIL))) {
    $emailreason = "E-mail format error ";
    $emailval = "False";
}
else{
    $result = mysqli_query($con,"SELECT * FROM Customer WHERE EMail='" . $_POST["EMail"] . "'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)){
        $emailval = "False";
        $emailreason2 = "Email already in use, please use a different email";
        if($row["EMail"] == $_POST["EMail"]){
            $emailval = "True";
            $emailreason2 = '';
        }
    }else{$emailval="True";}

}

// This checks if the firstname is validated by checking if it contains any special characters
$firstnameval = '';
$firstnamereason = '';
if(!preg_match("/^[a-zA-Z-]*$/",$_POST["FirstName"])) {
    $firstnamereason = "Firstname format error - Special characters are not allowed";
    $firstnameval = "False";
}
elseif(empty($_POST['FirstName'])){$firstnameval = "False";}
else{
    $firstnameval = "True";
}

// This checks if the lastname is validated by checking if it contains any special characters
$lastnameval = '';
$lastnamereason = '';
if(!preg_match("/^[a-zA-Z-]*$/",$_POST["LastName"])) {
    $lastnamereason = "Lastname format error - Special characters are not allowed";
    $lastnameval = "False";
}
elseif(empty($_POST['LastName'])){$lastnameval = "False";}
else{
    $lastnameval = "True";
}

// Checks if the username is validated by checking if it contains any special characters and if its in the database already
$usernameval = '';
$usernamereason = '';
if(empty($_POST['Username'])){$usernameval = "False";} 
elseif(!preg_match("/^[a-zA-Z-._0-9]*$/",$_POST["Username"])) {
    $usernamereason = "Username format error - Only letters and white spaces allowed";
    $usernameval = "False";
}else{
    $result = mysqli_query($con,"SELECT * FROM customer WHERE Username='" . $_POST["Username"] . "'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)){
        $usernameval = "False";
        $usernamereason = "Username already in use, please use a different Username";
        if($row["Username"] == $_POST["Username"]){
            $usernameval = "True";
            $usernamereason = '';
        }
    }else{$usernameval = "True";}

}

// Tel validation, checks if only numbers were entered, if its too short or too long and if it already exists in the database
$telval = '';
$telreason = '';
$telreason2 = '';
if (empty($_POST['Tel'])){$telval = "False";
}
elseif(!preg_match("/^[0-9]*$/",$_POST["Tel"])) {
    $telreason = "Only numbers can be entered as a telephone number";
    $telval = "False";
}
elseif(strlen($_POST['Tel']) <= '6') {
    $telreason = "The telephone number entered is too short";
    $telval = "False";
}
elseif(strlen($_POST['Tel']) >= '16') {
    $telreason = "The telephone number entered is too long";
    $telval = "False";
}
else{
    $result = mysqli_query($con,"SELECT * FROM Customer WHERE Tel='" . $_POST["Tel"] . "'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)){
        $telval = "False";
        $telreason2 = "Telephone Number already in use, please use a different Telephone Number";}
        if($row["Tel"] == $_POST["Tel"]){
            $telval = "True";
            $telreason2 = '';
        }
    
    else{$telval = "True";}
    }

?>
<?php
// Checks if any of the fields are empty. 
$emptycheckmsg = '';
$emptyval = '';
if((empty($_POST['FirstName']) Or empty($_POST['LastName']) Or empty($_POST['Username']) 
Or empty($_POST['Tel']) Or empty($_POST['EMail']) Or empty($_POST['gender'])) and isset($_POST['update']))   {
    $emptyval = "False";
    $emptycheckmsg = "Please fill out all the required fields";
}else{$emptyval = "True";}

?>
<?php
// If any of the variables are not validated, it will display a red box
if((($firstnameval == "False") Or ($emailval == "False") Or ($lastnameval == "False") Or ($usernameval == "False")
 Or ($telval == "False") Or ($emptyval == "False")) And isset($_POST['update'])){
    ?><div class="validation"><?php

} 

// This is where the validation messages will be outputted in the red box that will be displayed if any of the variables are not validated
if(isset($_POST['update'])){
if(($firstnameval == "False") Or ($emailval == "False") Or ($lastnameval == "False") Or ($usernameval == "False")
 Or ($telval == "False") Or ($emptyval == "False")){
 
    if($emptycheckmsg!='') { echo $emptycheckmsg, "<br>"; }; 
    if($firstnamereason!='') { echo $firstnamereason, "<br>" ; }; 
    if($lastnamereason!='') { echo $lastnamereason, "<br>"; }; 
    if($usernamereason!='') { echo $usernamereason, "<br>"; }; 
    if($telreason!='') { echo $telreason, "<br>"; }; 
    if($telreason2!='') { echo $telreason2, "<br>"; };
    if($emailreason!='') { echo $emailreason, "<br>"; };
    if($emailreason2!='') { echo $emailreason2, "<br>"; }; 
    ?></div><?php
}
else{
    // This gives the data entered a variable. It hashes the password.
    ?> <div class="validated"><?php
    echo "Everything is validated";
    echo "<br>";
    $firstname = $_POST['FirstName'];
    $lastname = $_POST['LastName'];
    $username = $_POST['Username'];
    $tel = $_POST['Tel'];
    $email = $_POST['EMail'];
    $gender = $_POST["gender"];
    #This code will update the user's information in the database
    $sql = "UPDATE Customer SET FirstName='{$firstname}', LastName = '{$lastname}',
    UserName = '{$username}', Tel = '{$tel}', EMail = '{$email}'
    WHERE CustomerID=" . $_POST['CustomerID'];
    if( $con->query($sql) === TRUE){
        echo "Successfully updated user";
        ?></div><?php
    }
    else{
        ?> <div class="validation"><?php
        echo "Error: There was an error while updating user info";
        ?></div><?php
    }
}
}

?>
<br><br>
<?php
require_once 'footer.php';