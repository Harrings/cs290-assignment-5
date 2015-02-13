<?php
ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Video Store</title>
</head>
<body>
<form action="addvideo.php" method="post">
		<p>name: <input type="text" name="moviename" /></p>
		<p>category: <input type="text" name="category" /></p>
		<p>length: <input type="number" name="length" min="1" max="500" /></p>	
		<br><br>
		<input type="submit" value="Submit">
</form>

<?php
if (!isset($_SESSION["sort"])||($_SESSION["sort"]=="All"))
{
	if (!$stmt = $mysqli->query("SELECT name, category, length, rented FROM VSTORE")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
}
else
{
	/*if (!$stmt = $mysqli->prepare("SELECT name, category, length FROM VSTORE WHERE category= ?")) {
		echo "Prepare Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
	$sorter=$_SESSION["sort"];
	if (!$stmt->bind_param("s", $sorter)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	*/
	$sorter=$_SESSION["sort"];
	if (!$stmt = $mysqli->query("SELECT name, category, length, rented FROM VSTORE WHERE category='$sorter'")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
	echo "Currently showing only $sorter films";
	$_SESSION["sort"]="All";
}

/*if (!$stmt->execute()) {
echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} */
?>

<table border="1">
<thead> 
<tr>
    <th>Title</th> 
    <th>Category</th> 
    <th>Length</th> 
    <th>Rented</th> 
    <th>Change Status</th> 
    <th>Delete</th>
</tr> 
</thead>
<tbody>
<?php
$cats=array();
while($row = mysqli_fetch_array($stmt))	
{
	echo "<tr>" ;
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['category'] . "</td>";
	echo "<td>" . $row['length'] . "</td>";
	echo "<td>";
	if (!$row['rented'])
	{
		echo "avalible </td>";
		echo "<td><form method=\"POST\" action=\"checkout.php\">";
		echo "<input type=\"hidden\" name=\"nameid\" value=\"".$row['name']."\">";
		echo "<input type=\"submit\" value=\"checkout\">";
		echo "</form> </td>";
	}
	else
	{
		echo "checked out </td>";
		echo "<td><form method=\"POST\" action=\"checkin.php\">";
		echo "<input type=\"hidden\" name=\"nameid\" value=\"".$row['name']."\">";
		echo "<input type=\"submit\" value=\"returned\">";
		echo "</form> </td>";
	}
	echo "<td><form method=\"POST\" action=\"delete.php\">";
	echo "<input type=\"hidden\" name=\"nameid\" value=\"".$row['name']."\">";
	echo "<input type=\"submit\" value=\"delete\">";
	echo "</form> </td>";
	if (!(in_array($row['category'], $cats)))
	{
		array_push($cats,$row['category']);
	}
	echo "</tr>";
}
?>
</tbody>
</table>
<form action="filter.php" method="POST">
<div align="center">
<select name="sort">
<option value="All">All Movies</option>
<?php
$x=count($cats);
for ($i=0;$i<$x; $i++)
{
	echo "<option value=$cats[$i]>$cats[$i]</option>";
}
?>
</select>
</div>
<input type="submit" value="Filter">
</form>
<form method="POST" action="deleteall.php">
<input type="hidden" name="deletekey" value="xjy">
<input type="submit" value="delete all">
</form>
	</body>
</html>	
	

	
