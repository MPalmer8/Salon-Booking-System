<?php
require_once 'connect.php';
require_once 'header1.php';
?>
<div class="container">
<?php
if(isset($_POST['addnew'])){
if( empty($_POST['FirstName']) or empty($_POST['LastName']) or empty($_POST['Username']) or empty($_POST['Passcode']) or empty($_POST['Tel']) or empty($_POST['EMail']) ){
echo "Please fillout all required fields";
}else{
$firstname = $_POST['FirstName'];
$lastname = $_POST['LastName'];
$username = $_POST['Username'];
$passcode = $_POST['Passcode'];
$tel = $_POST['Tel'];
$email = $_POST['EMail'];
$sql = "INSERT INTO Customer(FirstName,LastName,Username,Passcode,Tel,EMail)
VALUES('$firstname','$lastname','$username','$passcode','$tel','$email')";
if( $con->query($sql) === TRUE){
echo "<div class='alert alert-success'>Successfully added new user</div>";
}else{
echo "<div class='alert alert-danger'>Error: There was an error while adding new user</div>";
}
}
}
?>
<div class="row">
<div class="col-md-6 col-md-offset-3">
<div class="box">
<h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Add New User</h3>
<form action="" method="POST">
<label for="FirstName">Firstname</label>
<input type="text" id="FirstName" name="FirstName" class="form-control"><br>
<label for="LastName">Lastname</label>
<input type="text" id="LastName" name="Lastname" class="form-control"><br>
<label for="Username">Username</label>
<input type="text" id="Username" name="Username" class="form-control"><br>
<label for="Passcode">Password</label>
<input type="text" id="Passcode" name="Passcode" class="form-control"><br>
<label for="Tel">Telephone</label>
<input type="text" id="Tel" name="Tel" class="form-control"><br>
<label for="EMail">Email</label>
<input type="text" id="EMail" name="EMail" class="form-control"><br>

<input type="submit" name="addnew" class="btn btn-success" value="Add New">
</form>
</div>
</div>
</div>
</div>
<?php
require_once 'footer.php';