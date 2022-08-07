<?php
session_start();
unset($_SESSION["CustomerID"]);
unset($_SESSION["FirstName"]);
header("Location:login.php");


# $random=md5(rand());
# $captcha = subsstr($random,0,7)


?>



