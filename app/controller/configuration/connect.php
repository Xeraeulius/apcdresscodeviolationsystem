<?php
error_reporting(0);
$connect_error = '<h2><b style="color: red;">Sorry for the Server Down Time... The Administrator will facilitate the website.</b></h2>';

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'dresscodeviolationsystem';

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
	die($connect_error);
}
?>