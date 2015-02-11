<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", "minstFy7WEjCWSCr", "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>
<form action="addvideo.php" method="post">
		<p>name: <input type="text" name="username" /></p>
		<p>category: <input type="text" name="category" /></p>
		<p>length: <input type="number" name="length" min="1" max="5" /></p>	
		<br><br>
		<input type="submit" value="Submit">
</form>

<?php
if (!isset($_SESSION["sort"]||$_SESSION["sort"]=="All"))
{
	if (!$stmt = $mysqli->query("SELECT name, category, length,  FROM VSTORE")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
else
{
	if (!$stmt = $mysqli->query("SELECT name, category, length FROM VSTORE WHERE ?")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
		//bind parameter from $_SESSION["sort"]
}

if (!$stmt->execute()) {
echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
?>

<table>
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
$cats=array()
while($row = mysqli_fetch_array($stmt))	
{
	echo "<tr>" ;
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['category'] . "</td>";
	echo "<td>" . $row['length'] . "</td>";
	echo "<td>" .;
	if (!$row['rented'])
	{
		echo "avalible </td>";
		echo "<td><form method=\"POST\" action=\"checkout.php\">";
		echo "<input type=\"hidden\" name=\"nameid\" value=\"".row['name']."\">";
		echo "<input type=\"submit\" value=\"checkout\">";
		echo "</form> </td>";
	}
	else
	{
		echo "checked out </td>";
		echo "<td><form method=\"POST\" action=\"checkin.php\">";
		echo "<input type=\"hidden\" name=\"nameid\" value=\"".row['name']."\">";
		echo "<input type=\"submit\" value=\"returned\">";
		echo "</form> </td>";
	}
	echo "<td><form method=\"POST\" action=\"delete.php\">";
	echo "<input type=\"hidden\" name=\"nameid\" value=\"".row['name']."\">";
	echo "<input type=\"submit\" value=\"delete\">";
	echo "</form> </td>";
	if (!(in_array($row['category'], $cats)))
	{
		array_push($cats,$row['category'])
	}
}
?>
</tbody>
</table>
	
	

	
