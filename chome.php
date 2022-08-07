<!DOCTYPE html>
<?php include 'header.php';?> <?php include 'customermenu.php';?> <?php session_start(); ?> 
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
<div class="mainimage">
<img src="images/banner.jpg" alt="Paris" id="bodyImage">
</div>

</body>
<style>
h1 {text-align: center;}
</style>
<?php if($_SESSION["CustomerID"]){echo "";}else{header("Location:home.php");}
?>
<h1>Welcome to Lush Hair and Beauty Salon, <?php echo $_SESSION["FirstName"] ?> </h1>
</html>
<?php include 'footer.php';?>

