<html>
<link rel="stylesheet" type = "text/css" href="CSS/style.css">
<body>
<?php require_once 'connect.php';?>
<?php include 'header.php';?> <?php include 'menu.php'; error_reporting(E_ERROR | E_PARSE);;?>

<h3 align="center">Create an account</h3>
<form action="" method="POST" align="center">
<label for="FirstName">First Name:</label>
<br><input type="text" id="FirstName" name="FirstName" class="form-control"><br>
<label for="LastName">Last Name:</label>
<br><input type="text" id="LastName" name="LastName" class="form-control"><br>
<label for="Username">Username:</label>
<br><input type="text" id="Username" name="Username" class="form-control"><br>
<label for="Passcode">Password:</label>
<br><input type="password" id="Passcode" name="Passcode" class="form-control"><br>
<label for="Tel">Telephone:</label>
<br><input type="text" id="Tel" name="Tel" class="form-control"><br>
<label for="EMail">E-Mail:</label>
<br><input type="text" id="Email" name="EMail" class="form-control"><br>
<br>
<input type="radio" id="male" name="gender" value="M">
<label for="male">Male</label>
<input type="radio" id="female" name="gender" value="F">
<label for="female">Female</label>
<input type="radio" id="other" name="gender" value="Other">
<label for="other">Other</label>
<br>
<br><input type="submit" name="submit">
<input type="reset">
</form>
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
$usernamereason2 = '';
if(empty($_POST['Username'])){$usernameval = "False";} 
elseif(!preg_match("/^[a-zA-Z-._0-9]*$/",$_POST["Username"])) {
    $usernamereason = "Username format error - Special Characters are not allowed";
    $usernameval = "False";
}else{
    $result = mysqli_query($con,"SELECT * FROM Customer WHERE Username='" . $_POST["Username"] . "'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)){
        $usernameval = "False";
        $usernamereason2 = "Username already in use, please use a different Username";
    }else{$usernameval = "True";}

}

// Checks if password is the right length, contains one lowercase letter, one number, and one capital letter
$passwordval = '';
$passwordreason = '';
if (empty($_POST['Passcode'])){$passwordval = "False";
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
    
    else{$telval = "True";}
    }



// Checks if any of the fields are empty. 
$emptycheckmsg = '';
$emptyval = '';
if((empty($_POST['FirstName']) Or empty($_POST['LastName']) Or empty($_POST['Username']) Or empty($_POST['Passcode']) Or 
empty($_POST['Tel']) Or empty($_POST['EMail']) Or empty($_POST['gender'])) and isset($_POST['submit']))   {
    $emptyval = "False";
    $emptycheckmsg = "Please fill out all the required fields";
}else{$emptyval = "True";}

// If any of the variables are not validated, it will display a red box
if((($firstnameval == "False") Or ($emailval == "False") Or ($lastnameval == "False") Or ($usernameval == "False") Or ($passwordval == "False")
 Or ($telval == "False") Or ($emptyval == "False")) And isset($_POST['submit'])){
    ?><div class="validation"><?php

} 

// This is where the validation messages will be outputted in the red box that will be displayed if any of the variables are not validated
if(($firstnameval == "False") Or ($emailval == "False") Or ($lastnameval == "False") Or ($usernameval == "False") Or ($passwordval == "False")
 Or ($telval == "False") Or ($emptyval == "False")){

    if($emptycheckmsg!='') { echo $emptycheckmsg, "<br>"; }; 
    if($firstnamereason!='') { echo $firstnamereason, "<br>" ; }; 
    if($lastnamereason!='') { echo $lastnamereason, "<br>"; }; 
    if($usernamereason!='') { echo $usernamereason, "<br>"; };
    if($usernamereason2!='') { echo $usernamereason2, "<br>"; };
    if($passwordreason!='') { echo $passwordreason, "<br>"; }; 
    if($telreason!='') { echo $telreason, "<br>"; }; 
    if($telreason2!='') { echo $telreason2, "<br>"; };
    if($emailreason!='') { echo $emailreason, "<br>"; };
    if($emailreason2!='') { echo $emailreason2, "<br>"; }; 
    ?></div><?php

    

}
else{
    // This gives the data entered a variable. It hashes the password. Then it adds the data to the customer table 
    $firstname = $_POST['FirstName'];
    $lastname = $_POST['LastName'];
    $username = $_POST['Username'];
    $passcode = $_POST['Passcode'];
    if ($passcode != ''){
        $hashed_passcode = password_hash($passcode, PASSWORD_BCRYPT);
    }

    $tel = $_POST['Tel'];
    $email = $_POST['EMail'];
    $gender = $_POST["gender"];
    $sql = "INSERT INTO Customer(FirstName,LastName,Username,Passcode,Tel,EMail,Gender)
    VALUES('$firstname','$lastname','$username','$hashed_passcode','$tel','$email','$gender')";
    if( $con->query($sql) === TRUE){
    echo "<div class='validated'>Successfully added new user</div>";
    }else{echo "Error: failed to add user";}

}
?><br>
<?php require_once 'footer.php';  ?>
</body>
</html>


