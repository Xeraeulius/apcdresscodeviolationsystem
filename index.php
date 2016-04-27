<?php 
$title = "Dress Code Violation System";
$css = "custom";

require 'app/views/layouts/overall/static_header.php';
require 'app/controller/init.php';
revert_page_protection();
?>
<img src="app/assets/images/application_images/apc_logo.png" width="100" height="100">
<div class="search">
	<form action="index.php" method="POST">
		<input type="password" name="student_id" class="student_information" placeholder= "Student ID Number or Scan your ID in the RFID Scanner" autofocus required >
	</form>
	<div class="error_message">
		<?php
		if (isset($_POST['student_id'])) {
			$search_id = $_POST['student_id'];
			$_SESSION['student_id'] = $search_id;

			if (validate_student($search_id)) {
				if (violation_ticket_today($search_id)) {
					include 'app/views/widgets/violation_today.php';
				} elseif (!student_has_notification($search_id)) {
					include 'app/views/widgets/violation_login.php';
				} elseif (student_has_notification($search_id)) {
					include 'app/views/widgets/violation_login.php';
					include 'app/views/widgets/notification_details.php';
				}
			} else {
			?>
				<div class="alert alert-danger" role="alert">
					<meta http-equiv="refresh" content="3; URL='index.php'" />
					<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					<span class="danger_message">Please Register and Accommodate your Student Account in the IT Resource Office.</span>
				</div>
			<?php
			}
		}
		if (isset($_GET['success'])) {
		?>
				<div class="alert alert-success">
					<meta http-equiv="refresh" content="2; URL='index.php'" />
					<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
					<span class="success_message">Violation Ticket has been processed. For more information login to the APC Violation Website.</span>
				</div>
		<?php
		}
		?>
	</div>
</div>
<?php
require 'app/views/layouts/overall/static_footer.php';
?>