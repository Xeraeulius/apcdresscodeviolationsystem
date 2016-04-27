<?php 
require 'app/controller/init.php';
protect_page();

$filename = 'C:/xampp/htdocs/ADVWEB/apcviolation/violation_images/' . date('YmdHis') . '.jpg';
$filename_upload_here = 'violation_images/' . date('YmdHis') . '.jpg';

$result = file_put_contents( $filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

$result_upload_here = file_put_contents( $filename_upload_here, file_get_contents('php://input') );
if (!$result_upload_here) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename_upload_here;
$_SESSION['upload_url'] = $filename_upload_here;
print "$url";
?>