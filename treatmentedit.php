<?php
require_once 'connect.php'; require_once 'header.php'; require_once 'staffmenu.php';
session_start(); 
if($_SESSION["StaffID"]){echo "";}
else{header("Location:home.php");}
?><div class="container"><?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$sql = "SELECT * FROM treatment WHERE TreatmentID={$id}";
$result = $con->query($sql);
if($result->num_rows < 1){
header('Location: index.php');
exit; }
$row = $result->fetch_assoc(); ?>
<div class="row">
<div class="col-md-6 col-md-offset-3">
<div class="box">
<h3 align="center"><i class="glyphicon glyphicon-plus"></i>&nbsp;MODIFY Treatment</h3>
<form action="" method="POST" align="center">
<input type="hidden" value="<?php echo $row['TreatmentID']; ?>" name="TreatmentID">
<label for="TreatmentName">Treatment Name:</label><br>
<input type="text" id="TreatmentName" name="TreatmentName" value="<?php echo $row['TreatmentName']; ?>" class="form-control"><br>
<label for="Cost">Cost:</label><br>
<input type="text" name="Cost" id="Cost" value="<?php echo $row['Cost']; ?>" class="form-control"><br>
<label for="TreatmentDescription">Description:</label><br>
<input type="text" name="TreatmentDescription" id="TreatmentDescription" value="<?php echo $row['TreatmentDescription']; ?>" class="form-control"><br>
<br><input type="submit" name="update" class="btn btn-success" value="Update">
</form></div></div></div></div>
<?php #This checks if the treatment the user has entered is in the correct format
$treatmentval = "";
$treatmentmsg = "";
if(empty($_POST['TreatmentName'])){$treatmentval = "False";} 
elseif(!preg_match("/^[a-zA-Z ]*$/",$_POST["TreatmentName"])) {
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
}else{$emptyval = "True";}

if(isset($_POST['update'])){
    if(($treatmentval == "False") or ($costval == "False") or ($emptyval == "False")){
        ?><div class="validation"><?php
        #These will contain messages alerting the user of any issues their inputs may have
        if($emptymsg!='') { echo $emptymsg, "<br>"; };
        if($treatmentmsg!='') { echo $treatmentmsg, "<br>"; };
        if($costmsg!='') { echo $costmsg, "<br>"; };
        ?></div><?php
    }else{
        $name = $_POST['TreatmentName'];
        $cost = $_POST['Cost'];
        $description = $_POST['TreatmentDescription'];
        #This will uppdate the details of the treatment in the database
        $sql = $sql = "UPDATE treatment SET TreatmentName='{$name}', Cost = '{$cost}', TreatmentDescription = '{$description}'
        WHERE TreatmentID=" . $_POST['TreatmentID'];
        if( $con->query($sql) === TRUE){
            ?><div class="validated"><?php
            echo "Successfully updated treatment";
            ?></div><?php
        }else{
            ?><div class="validation"><?php
            echo "Error: failed to update treatment";
            ?></div><?php
        }
    }
}
?>
<br><br><br><br><br><br><br><br><br>
<?php
require_once 'footer.php';