<html>
<body>
<?php require_once 'connect.php';?>
<?php include 'header.php';?> <?php include 'menu.php';?>


<h3 align="center">Create a Staff account</h3>
<form action="" method="POST" align="center">
FirstName:<br><input type="text" name="FirstName"><br>
LastName: <br><input type="text" name="LastName"><br>
Username: <br><input type="text" name="Username"><br>
Password: <br><input type="password" name="Passcode"><br>
<br><input type="submit">
<input type="reset">
</form>







<?php 



$firstnameval = '';
$firstnamereason = '';
if(!preg_match("/^[a-zA-Z-]*$/",$_POST["FirstName"])) {
    $firstnamereason = "Firstname format error - Special characters are not allowed";
    $firstnameval = "False";
}else{
    $firstnameval = "True";
}



$lastnameval = '';
$lastnamereason = '';
if(!preg_match("/^[a-zA-Z-]*$/",$_POST["LastName"])) {
    $lastnamereason = "Lastname format error - Special characters are not allowed";
    $lastnameval = "False";
}else{
    $lastnameval = "True";
}



$usernameval = '';
$usernamereason = '';
$usernamereason2 = '';
if(!preg_match("/^[a-zA-Z-._1-9]*$/",$_POST["Username"])) {
    $usernamereason = "Username format error - Only letters and white space allowed";
    $usernameval = "False";
}else{
    $result = mysqli_query($con,"SELECT * FROM Customer WHERE Username='" . $_POST["Username"] . "'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)){
        $usernameval = "False";
        $usernamereason2 = "Username already in use, please use a different Username";
    }else{$usernameval = "True";}

}



$passwordval = '';
$passwordreason = '';
if (empty($_POST['Passcode'])){
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



?>

<?php
$emptycheckmsg = '';
$emptyval = '';
if((empty($_POST['FirstName']) Or empty($_POST['LastName']) Or empty($_POST['Username']) Or empty($_POST['Passcode']))   ){
    $emptyval = "False";
    $emptycheckmsg = "Please fill out all the required fields";
}else{$emptyval = "True";}
?>




?>
<style>
.validation {
  background-color: tomato;
  color: white;
  border: 2px solid black;
  margin: 200px;
  padding: 10px;
}
</style>
<div class="validation">
<?php
if(($firstnameval = "False") And ($lastnameval = "False") And ($usernameval = "False") And ($passwordval = "False")
  And ($emptyval = "False")  ){
    if($emptycheckmsg!='') { echo $emptycheckmsg, "<br>"; }; 
    if($firstnamereason!='') { echo $firstnamereason, "<br>" ; }; 
    if($lastnamereason!='') { echo $lastnamereason, "<br>"; }; 
    if($usernamereason!='') { echo $usernamereason, "<br>"; };
    if($usernamereason2!='') { echo $usernamereason2, "<br>"; };
    if($passwordreason!='') { echo $passwordreason, "<br>"; };  

}

if(($firstnameval = "True") And ($lastnameval = "True") And ($usernameval = "True") And ($passwordval = "True")
    And ($emptyval = "True")  ){
        if((empty($_POST['FirstName']) Or empty($_POST['LastName']) Or empty($_POST['Username']) Or empty($_POST['Passcode'])))  {
            echo "";
        }else{
            echo "Everything is validated";
            $firstname = $_POST['FirstName'];
            $lastname = $_POST['LastName'];
            $username = $_POST['Username'];
            $passcode = $_POST['Passcode'];
            if ($passcode != ''){
                $hashed_passcode = password_hash($passcode, PASSWORD_BCRYPT);
            }

            $sql = "INSERT INTO Staff(StaffFirstName,StaffLastName,StaffUsername,Passcode)
            VALUES('$firstname','$lastname','$username','$hashed_passcode')";
            if( $con->query($sql) === TRUE){
            echo "<div class='alert alert-success'>Successfully added new user</div>";
            }else{echo "Error: failed to add user";}
            
            
          
            }

    }else{}
?>
</div>




</body>
</html>