<div class="alert alert-warning" role="alert">
	<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	<span class="sr-only">Reminder:</span>
	<span class="danger_message">
		Violation Ticket has been processed. For more information
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal2">View Ticket</button>
		<a href="index.php"><button class="btn btn-success" type="button" name="btn_cancel">Close</button></a>
	</span>
</div>

<div id="myModal2" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<img src="app/assets/images/application_images/violation.png" width="180" height="100" style="margin-bottom: 13px;">
				<h3 class="modal-title">Dress Code Violation</h3>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<!-- Insert Violation Ticket Report of the Student -->
			<?php 
				if (initialize_token() === TRUE) {
					global $conn;
					$search_id = $_SESSION['student_id'];
					date_default_timezone_set('Asia/Manila');
					$date_today = date('j');

					$select = "SELECT 	students.last_name		AS student_last_name,
										students.first_name		AS student_first_name,
								        students.middle_name	AS student_middle_name,
								        students.id_picture,
								        
								        violation_details.status,
								        DATE_FORMAT(violation_details.created_at, '%b %d, %Y - %h:%i %p') AS created_at,
								        
								        disciplinary_personnels.last_name,
								        disciplinary_personnels.first_name,
								        disciplinary_personnels.middle_name,
								        disciplinary_personnels.dp_picture

								FROM violation_details

								LEFT JOIN students
								ON students.student_id = violation_details.student_id

								LEFT JOIN disciplinary_personnels
								ON disciplinary_personnels.dp_id = violation_details.dp_id

								WHERE (students.student_id = :search_id OR students.card_id = :search_id) AND EXTRACT(DAY FROM violation_details.created_at) = :date_today";
					
					$result = $conn->prepare($select);
					$result->execute(array(
											':search_id'  => $search_id, 
											':date_today' => $date_today
										  ));
					$student = $result->fetchAll();
					
					if ($student) {
						foreach ($student as $row) {
							$id_picutre = $row['id_picture'];
			?>
							<div class="ticket_info">
								<img src="<?php echo $id_picutre; ?>" width="120" height="120" class="img-thumbnail" style="float: left;">
								<label class="form_name" style="margin-right: 118px;">Name</label>
								<input type="text" class="form-control" value="<?php echo $row['student_last_name'] . ", " . $row['student_first_name'] . " " . $row['student_middle_name']; ?>" disabled style="width: 250px;">
								<label class="form_name" style="margin-top: 20px; margin-right: 113px;">Status</label>
								<p style="margin-top: 17px; font-size: 18px;"><?php echo $row['status'] ?></p>
								<label class="form_name" style="margin-top: 9px; margin-right: 72px;">Issued Date</label>
								<p style="margin-top: 21px; font-size: 18px;"><?php echo $row['created_at'] ?></p>
							</div>
							<div class="ticket_info">
								<img src="<?php echo $row['dp_picture']; ?>" width="120" height="120" class="img-thumbnail" style="float: left;">
								<label class="form_name" style="margin-right: 30px; margin-top: 40px;">Issued By</label>
								<input type="text" class="form-control" value="<?php echo $row['last_name'] . ", " . $row['first_name'] . " " . $row['middle_name']; ?>" disabled style="width: 250px; margin-right: 5px; margin-top: 35px; display: inline; float: right;">
							</div>
							<div class="space">
								<p style="margin-bottom: 30px;"></p>
							</div>
			<?php  
						}
					}
				}
			?>
			</div>
			<div class="modal-footer" style="margin-top: 100px;">
				<a href="index.php"><button type="button" class="btn btn-primary">Close</button></a>
			</div>
		</div>
	</div>
</div>