<?php
ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();

$_SESSION["sort"]=$_POST["sort"];
header("Location: video.php", true);
?>
