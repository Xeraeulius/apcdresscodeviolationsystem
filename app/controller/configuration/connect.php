<?php
// DB connection info
//TODO: Update the values for $host, $user, $pwd, and $db
//using the values you retrieved earlier from the Azure Portal.
$host = "ap-cdbr-azure-southeast-b.cloudapp.net";
$user = "b94ffec3b9a5b1";
$pwd = "35d53d72";
$db = "dresscodeviolation";
// Connect to database.
try {
    $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(Exception $e){
    die(var_dump($e));
}
?>