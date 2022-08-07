<!DOCTYPE html>
<?php include 'header.php';?> <?php include 'staffmenu.php';?> <?php session_start(); ?> 
<html>

<head>
<style>
#bodyImage {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>
</head>
<body>
<img src="images/banner.jpg" alt="Paris" id="bodyImage">

</body>
<style>
h1 {text-align: center;}
</style>
<?php if($_SESSION["StaffID"]){echo "";}else{header("Location:home.php");}
?>
<h1>Welcome to Lush Hair and Beauty Salon, <?php echo $_SESSION["StaffFirstName"] ?> </h1>
</html>
<?php include 'footer.php';?>




