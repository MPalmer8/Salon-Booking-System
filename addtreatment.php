<?php
require_once 'connect.php';
require_once 'header.php'; 
require_once 'staffmenu.php';
// This code checks if a staff member is logged in 
session_start(); 
if($_SESSION["StaffID"]){echo "";}else{header("Location:home.php");} ?>
<hmtl>
<head> 
<title> Add a Treatment </title>
</head> 
<body>
<h2 align="center">Add a Treatment</h2>
<form action="" method="POST" align="center">
<label for="TreatmentName">Treatment Name:</label>
<br><input type="text" id="TreatmentName" name="TreatmentName" class="form-control"><br>
<label for="Cost">Cost (£):</label>
<br><input type="integer" id="Cost" name="Cost" class="form-control"><br>
<label for="TreatmentDescription">Description</label>
<br><input type="text" id="TreatmentDescription" name="TreatmentDescription" class="form-control"><br>
<p>Descriptions can be a maximum of 200 characters</p>
<br><input type="submit" name="submit">
<input type="reset"><br><br>
<?php
#This checks if the treatment the user has entered is in the correct format
$treatmentval = "";
$treatmentmsg = "";
if(empty($_POST['TreatmentName'])){$treatmentval = "False";} 
elseif(!preg_match("/^[a-zA-Z-._]*$/",$_POST["TreatmentName"])) {
    $treatmentmsg = "Treatment format error - Only letters and white spaces allowed";
    $treatmentval = "False";
}else{$treatmentval = "True";}

#This checks if cost only contains integers and has information entered
$costval = "";
$costmsg = "";
if (empty($_POST['Cost'])){$costval = "False";
}
elseif(!preg_match("/^[0-9]*$/",$_POST["Cost"])) {
    $costmsg = "Only numbers can be entered in the cost field";
    $costval = "False";
}else{$costval = "True";}

#This code checks if any of the fields are empty
$emptyval = "";
$emptymsg = "";
if( (empty($_POST['TreatmentName'])) or (empty($_POST['Cost'])) or (empty($_POST['TreatmentDescription'])) ){
    $emptyval = "False";
    $emptymsg = "Please fill out all the required fields";
}
else{$emptyval = "True";}

if(isset($_POST['submit'])){
    if(($treatmentval == "False") Or ($costval == "False") Or ($emptyval == "False")){
        #These will contain messages alerting the user of any issues their inputs may have
        ?><div class="validation"><?php
        if($treatmentmsg!='') { echo $treatmentmsg, "<br>"; };
        if($costmsg!='') { echo $costmsg, "<br>"; };
        if($emptymsg!='') { echo $emptymsg, "<br>"; };
        ?></div><?php

    }
    else{
        $name = $_POST['TreatmentName'];
        $cost = $_POST['Cost'];
        $description = $_POST['TreatmentDescription'];
    
        #This will add the details of the new treatment to the database
        $sql = "INSERT INTO treatment(TreatmentName,Cost,TreatmentDescription)
        VALUES('$name','$cost','$description')";
        if( $con->query($sql) === TRUE){
        echo "<div class='validated'>Successfully added new treatment</div>";
        }else{echo "<div class='validation'>Error: failed to add new treatment</div>";}
    }
}
?>
</form>
</body> 
</hmtl>
<br><br><br><br><br><br><br><br>
<?php include 'footer.php' ?>