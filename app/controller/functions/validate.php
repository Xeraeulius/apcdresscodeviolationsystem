<?php 
	function initialize_token() {
		return (isset($_SESSION['student_id'])) ? TRUE : FALSE;
	}

	function validate_student($search_id) {
		global $conn;
		$select = "SELECT COUNT(card_id) as card_id, COUNT(student_id) as student_id from students WHERE card_id = $search_id OR student_id = '$search_id'";
		$result = $conn->query($select);

		if ($result) {
			while ($row = $result->fetch_object()) {
				$search_id = $row->card_id;
			}
		}
		return ($search_id == 1) ? TRUE : FALSE;
	}

	function no_powertripping($id, $password) {
		global $conn;
		$select = "SELECT COUNT(id) as count from students where (student_id = '$id' OR card_id = '$id') AND password = '$password'";
		$query = $conn->query($select);

		while ($row = $query->fetch_object()) {
			$count = $row->count;
		}

		return ($count == 1) ? TRUE : FALSE;
	}

	function violation_ticket_today($search_id) {
		global $conn;

		date_default_timezone_set('Asia/Manila');
		$date_today = date('j');
		$select = "SELECT EXTRACT(DAY FROM violation_details.created_at) AS Day FROM violation_details 
				   LEFT JOIN students ON violation_details.student_id = students.student_id 
				   WHERE violation_details.student_id = '$search_id' OR students.card_id = '$search_id'";

		$result = $conn->query($select);
		while ($row = $result->fetch_object()) {
			$day = $row->Day;
		}

		if ($day == $date_today) {
			return true;
		}
	}

	function disciplinary_personnel_rights() {
		if (isset($_POST['disciplinary_id'])) {
			$disciplinary_id = $_POST['disciplinary_id'];
			$search_id = $_SESSION['student_id'];
			
			if (determine_personnel($disciplinary_id) && $search_id) {
				$search_id = student_information($search_id);

				$violation_information = array(
											      'student_id'        => student_information($search_id),
											      'dp_id' 			  => $_POST['disciplinary_id'],
											      'remarks'           => $_POST['txt_area'],
											      'school_term_id'	  => school_term(),
											      'violation_picture' => $_SESSION['upload_url']
											  );
				if (violation_ticket($violation_information) === TRUE) {
					header('Location: index.php?success');
					$id = violation_details_id($search_id);
					$violation_code = $_POST['violation'];

					foreach ($violation_code as $value) {
						violation_of_student($id, $value);
					}
				}
			} else { 
				require 'app/views/widgets/authorized_personnel.php';
			}
		}
	}

	function determine_gender($gender) {
		global $conn;
		$select = "SELECT gender from students where card_id = $gender OR student_id = '$gender'";
		$result = $conn->query($select);

		if($result) {
			while ($row = $result->fetch_object()) {
				$gender = $row->gender;
			}
		}
		return $gender;
	}

	function determine_personnel($disciplinary_personnel_id) {
		global $conn;
		$select = "SELECT COUNT(dp_id) as dp_id from disciplinary_personnels WHERE dp_id = $disciplinary_personnel_id";
		$result = $conn->query($select);

		if ($result) {
			while ($row = $result->fetch_object()) {
				$disciplinary_personnel_id = $row->dp_id;
			}
		}
		return ($disciplinary_personnel_id == 1) ? TRUE : FALSE;
	}

	function student_information($search_id) {
		global $conn;
		$select = "SELECT student_id from students where card_id = $search_id OR student_id = '$search_id'";
		$result = $conn->query($select);

		if ($result) {
			while ($row = $result->fetch_object()) {
				$student_id = $row->student_id;
			}
		}
		return $student_id;
	}

	function violation_details_id($search_id) {
		global $conn;
		$select = "SELECT id from violation_details where student_id = '$search_id'";
		$result = $conn->query($select);

		if ($result) {
			while ($row = $result->fetch_object()) {
				$id = $row->id;
			}
		}
		return $id;	
	}
	
	function violation_ticket($violation_information) {
		global $conn;
		$fields = '`' . implode('`, `', array_keys($violation_information)) . '`';
		$data = '\'' . implode('\', \'', $violation_information) . '\'';
		$date = created_at;
		$valid_date = valid_date;

		$insert = "INSERT INTO violation_details($fields, $date, $valid_date) VALUES ($data, NOW(), DATE_ADD(NOW(), INTERVAL 2 DAY))";

		$result = $conn->query($insert);

		if ($result) {
			return TRUE;
		}
	}

	function school_term() {
		global $conn;

		$select = "SELECT school_term.id from school_term where status = 'Active'";
		$query = $conn->query($select);

		while ($row = $query->fetch_object()) {
			$id = $row->id;
		}

		if (!empty($id)) {
			return $id;
		}
	}

	function violation_of_student($id, $value) {
		global $conn;

		$insert = "INSERT INTO violations(id, violation_code) VALUES ('$id', '$value')";
		$result = $conn->query($insert);

		if ($result) {
			session_unset();
			session_destroy();
		}
	}

	function get_student_id($student_id) {
		global $conn;

		$select = "SELECT id from students WHERE student_id = '$student_id'";
		$query = $conn->query($select);

		while ($row = $query->fetch_object()) {
			$id = $row->id;
		}

		return $id;
	}

	function student_has_notification($student_id) {
		global $conn;

		$id = get_student_id($student_id);
		$select = "SELECT 		COUNT(message_details.status) as status

					FROM		message_details

					LEFT JOIN	students
					ON			message_details.student_id = students.id

					WHERE		message_details.student_id = '$id' AND message_details.status = 'Pending'";

		$query = $conn->query($select);
		while ($row = $query->fetch_object()) {
			$status = $row->status;
		}

		return $status;
	}

	function number_of_notifications($student_id) {
		global $conn;

		$count = get_student_id($student_id);

		$select = "SELECT COUNT(student_id) as student_id from message_details where student_id = '$count' AND status = 'Pending'";
		$query = $conn->query($select);

		while ($row = $query->fetch_object()) {
			$id = $row->student_id;
		}

		return $id;
	}

	function two_violation_count($student_id) {
		global $conn;

		$select = "SELECT 	COUNT(violation_details.id) as violations 
				   FROM 	violation_details 
				   WHERE	violation_details.student_id = '$student_id' AND 
					    	(violation_details.status = 'Violated' AND violation_details.ticket_partial = 0)";
    	$result = $conn->query($select);

    	while ($row = $result->fetch_object()) {
    		$violations = $row->violations;
    	}

    	return $violations;
	}

	function update_ticket_flagged($student_id) {
		global $conn;

		$update = "UPDATE violation_details SET ticket_partial = 1 WHERE student_id = '$student_id' AND status = 'Violated'";

		$result = $conn->query($update);
	}
?>