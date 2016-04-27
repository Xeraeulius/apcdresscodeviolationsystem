<?php 
$title = "Student Violation";
$css = "custom";

require 'app/views/layouts/overall/static_header.php';
require 'app/controller/init.php';
protect_page();

######################################################
if (initialize_token() === TRUE) {
	if (isset($_POST['btn_submit'])) {
		$value = $_POST['btn_submit'];
		$password = md5($_POST['field_password']);

		if (no_powertripping($value, $password) === TRUE) {
		global $conn;
		$search_id = $_SESSION['student_id'];

		$select = "SELECT * from students WHERE card_id = $search_id OR student_id = '$search_id'";
		$result = $conn->query($select);

		if ($result) {
			while ($row = $result->fetch_object()) {
?>
<img src="app/assets/images/application_images/violation.png" width="180" height="100">
<?php  
		if (two_violation_count($search_id) == 2) {
			update_ticket_flagged($search_id);
			require 'app/views/widgets/advise.php';
		}
?>
	<div class="form_student">
		<div class="student_name">
			<label class="form_name">Name</label>
			<input type="text" class="form-control" value="<?php echo $row->last_name . ", " . $row->first_name . " " . $row->middle_name; ?>" disabled>
		</div>
		<div class="student_name student_course">
			<label class="form_course">Course</label>
			<input type="text" class="form-control" value="<?php echo $row->course; ?>" disabled>
		</div>
		<div class="student_picture">
			<img src="<?php echo $row->id_picture; ?>" width="160" height="160" class="img-thumbnail">
		</div>
	</div>
<?php 
			}
		}
?>
	<div class="violation_information">
		<form method="POST" action="process.php">
			<div class="violation_reason">
				<label class="violation_label">List of Dress Code Violation :</label>
				<div class="violation_type">
				<?php 
					$gender = $search_id;
					switch(determine_gender($gender)) {
						case "Male":
							require 'app/views/widgets/male_violation.php';
							break;
						case "Female":
							require 'app/views/widgets/female_violation.php';
							break;
					}
				?>
				</div>
			</div>
			<div class="violation_remarks">
				<label class="violation_label">Reason for Violation :</label><br>
				<textarea name="txt_area" rows="5" cols="40"></textarea><br>
			</div>
			<?php 
				ob_start();
				require 'app/views/widgets/webcam.php'; 
			?>
			<div class="validate_submission">
				<div class="input-group">
					<span class="input-group-addon" id="sizing-addon1"><img src="app/assets/images/application_images/paperandpen.png"></span>
					<input type="password" class="form-control" name="disciplinary_id" placeholder="Authorized Personnel">
					<a href="index.php"><button class="btn btn-primary" type="button" name="btn_cancel">Cancel</button></a>
				</div>
			</div>
		</form>
<?php 
		} else {
			require 'app/views/widgets/wrong_password.php';
		}
	}
}
require 'app/views/layouts/overall/static_footer.php';
?>