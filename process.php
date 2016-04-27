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
	}

		global $conn;
		$search_id = $_SESSION['student_id'];

		$select = "SELECT * from students WHERE card_id = $search_id OR student_id = '$search_id'";
		$result = $conn->query($select);
		$stmt = $result->fetchAll();

		foreach ($stmt as $row) {
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
			<input type="text" class="form-control" value="<?php echo $row['last_name'] . ", " . $row['first_name'] . " " . $row['middle_name']; ?>" disabled>
		</div>
		<div class="student_name student_course">
			<label class="form_course">Course</label>
			<input type="text" class="form-control" value="<?php echo $row['course']; ?>" disabled>
		</div>
		<div class="student_picture">
			<img src="<?php echo $row['id_picture']; ?>" width="160" height="160" class="img-thumbnail">
		</div>
	</div>
<?php 
		}
}
?>
	<div class="violation_information">
		<form method="POST" action="process.php" enctype="multipart/form-data">
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
	if (isset($_POST['disciplinary_id'])) {
		$disciplinary_id = $_POST['disciplinary_id'];
		$search_id = $_SESSION['student_id'];
		$school = school_term();
		
		if (determine_personnel($disciplinary_id) && $search_id) {
			$search_id = student_information($search_id);

			$sql_insert = "INSERT INTO violation_details (
															student_id,
															dp_id,
															remarks,
															valid_date,
															status,
															partial_seen,
															ticket,
															ticket_partial,
															violation_picture,
															created_at,
															school_term_id
														 ) 
 												  VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 2 DAY), ?, ?, ?, ?, ?, NOW(), ?)";
			$stmt_insert = $conn->prepare($sql_insert);
			$stmt_insert->bindValue(1, $search_id);
			$stmt_insert->bindValue(2, $_POST['disciplinary_id']);
			$stmt_insert->bindValue(3, $_POST['txt_area']);
			$stmt_insert->bindValue(4, 'Pending');
			$stmt_insert->bindValue(5, 0);
			$stmt_insert->bindValue(6, 'Clear');
			$stmt_insert->bindValue(7, 0);
			$stmt_insert->bindValue(8, 'NONE');
			$stmt_insert->bindValue(9, $school);
			$stmt_insert->execute();


			// $violation_information = array(
			// 							      'student_id'        => student_information($search_id),
			// 							      'dp_id' 			  => $_POST['disciplinary_id'],
			// 							      'remarks'           => $_POST['txt_area'],
			// 							      'valid_date'		  => 0,
			// 							      'status'			  => 'Pending',
			// 							      'partial_seen'	  => 0,
			// 							      'ticket'			  => 'Clear',
			// 							      'ticket_partial'    => 0,
			// 							      'violation_picture' => 'NONE',
			// 							      'created_at'		  => '2016-04-15 18:49:29',
			// 							      'school_term_id'	  => school_term()
			// 							  );

			header('Location: index.php?success');
			$id = violation_details_id($search_id);
			$violation_code = $_POST['violation'];

			foreach ($violation_code as $value) {
				violation_of_student($id, $value);
			}
		} else { 
?>
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				<span class="danger_message">Authorized Personnel can only accommodate the Violation Ticket</span>
			</div>
<?php
		}
	}
require 'app/views/layouts/overall/static_footer.php';
?>