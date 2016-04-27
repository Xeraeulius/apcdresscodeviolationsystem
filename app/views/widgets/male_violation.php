<?php  
$select = "SELECT * FROM violation_code where (gender = 'MALE' OR gender = 'EVERYONE') AND active = 'YES'";
$query = $conn->query($select);
$stmt = $query->fetchAll();

if (count($stmt) >= 0) {
	foreach ($stmt as $row) {
?>
	<label><input type="checkbox" name="violation[]" value="<?php echo $row['violation_code']; ?>"><?php echo $row['name']; ?></label><br/>
<?php 
	}
}
?>