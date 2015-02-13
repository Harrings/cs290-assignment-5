<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", "", "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if(!$mysqli->query("CREATE Table VSTORE(
id INT auto_increment PRIMARY KEY,
name VARCHAR (255) NOT NULL Unique,
category VARCHAR(255),
length INT unsigned,
rented boolean NOT NULL default 0
);
")) {
	echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
?>