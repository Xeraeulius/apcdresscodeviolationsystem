<?php  
$select = "SELECT * FROM violation_code where (gender = 'MALE' OR gender = 'EVERYONE') AND active = 'YES'";
$query = $conn->query($select);
	while ($row = $query->fetch_object()) {
?>
	<label><input type="checkbox" name="violation[]" value="<?php echo $row->violation_code; ?>"><?php echo $row->name; ?></label><br/>
<?php 
}
?>