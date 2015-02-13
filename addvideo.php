<?php
ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
$error=0;
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if (($_POST["moviename"]==null))
{
	echo "Error to add a video it must have a name click <a href=\"video.php\">here</a> to return to inventory managment";
}
else
{
	$name=$_POST["moviename"];
	$category=$_POST["category"];
	$length=$_POST["length"];

	if (!($stmt = $mysqli->prepare("INSERT INTO VSTORE(name, category, length) VALUES (?,?,?)"))) {
		 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		 $error=1;
	}
	if (!$stmt->bind_param("ssi", $name, $category, $length)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		$error=1;
	}
	if (!$stmt->execute()) {
		//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		$error=1;
	}
	$stmt->close();
	if ($error==0)
	{
		header("Location: video.php", true);
	}
	else
	{
		echo "Error there is already a video with the same name in the inventory click <a href=\"video.php\">here</a> to return to inventory managment";
	}
}
?>
