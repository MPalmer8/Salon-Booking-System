<?php
require_once 'connect.php';
require_once 'header1.php';
echo "<div class='container'>";
if( isset($_POST['delete'])){
$sql = "DELETE FROM Customer WHERE CustomerID=" . $_POST['CustomerID'];
if($con->query($sql) === TRUE){
echo "<div class='alert alert-success'>Successfully delete user</div>";
}
}
$sql = "SELECT * FROM Customer";
$result = $con->query($sql);
if( $result->num_rows > 0)
{
?>
<h2>List of all Users</h2>
<table class="table table-bordered table-striped">
<tr>
<td>Firstname</td>
<td>Lastname</td>
<td>Username</td>
<td>Tel</td>
<td>E-Mail</td>
<td width="70px">Delete</td>
<td width="70px">EDIT</td>
</tr>
<?php
while( $row = $result->fetch_assoc()){
echo "<form action='' method='POST'>"; //added
echo "<input type='hidden' value='". $row['CustomerID']."' name='CustomerID' />"; //added
echo "<tr>";
echo "<td>".$row['FirstName'] . "</td>";
echo "<td>".$row['LastName'] . "</td>";
echo "<td>".$row['Username'] . "</td>";
echo "<td>".$row['Tel'] . "</td>";
echo "<td>".$row['EMail'] . "</td>";
echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' /></td>";
echo "<td><a href='edit.php?id=".$row['CustomerID']."' class='btn btn-info'>Edit</a></td>";
echo "</tr>";
echo "</form>"; //added
}
?>
</table>
<?php
}
else
{
echo "<br><br>No Record Found";
}
?>
</div>
<?php
require_once 'footer.php';