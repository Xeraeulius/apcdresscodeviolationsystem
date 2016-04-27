<?php 
	function initialize_token() {
		return (isset($_SESSION['student_id'])) ? TRUE : FALSE;
	}

	function validate_student($search_id) {
		global $conn;
		$select = "SELECT COUNT(card_id) as card_id, COUNT(student_id) as student_id from students WHERE card_id = :search_id OR student_id = :search_id";
		$prepare = $conn->prepare($select);
		$prepare->execute(array(':search_id' => $search_id));
		$student = $prepare->fetchAll();

		if (count($student) > 0) {
			foreach ($student as $row) {
				$id = $row['card_id'];
			}
		} else {
			echo "<h3>Error: 500</h3>";
		}

		return ($id == 1) ? TRUE : FALSE;
	}

	function violation_ticket_today($search_id) {
		global $conn;

		date_default_timezone_set('Asia/Manila');
		$date_today = date('j');
		$select = "SELECT EXTRACT(DAY FROM violation_details.created_at) AS day FROM violation_details 
				   LEFT JOIN students ON violation_details.student_id = students.student_id 
				   WHERE violation_details.student_id = '$search_id' OR students.card_id = '$search_id'";

		$stmt = $conn->query($select);
		$violation = $stmt->fetchAll();

		foreach ($violation as $row) {
			$day = $row['day'];
		}

		if ($day == $date_today) {
			return true;
		}
	}

	function get_student_id($student_id) {
		global $conn;

		$select = "SELECT id from students WHERE student_id = :student_id";
		$query = $conn->prepare($select);
		$query->execute(array(':student_id' => $student_id));
		$student = $query->fetchAll();

		if (count($student) > 0) {
			foreach ($student as $row) {
				$id = $row['id'];
			}
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

					WHERE		message_details.student_id = $id AND message_details.status = 'Pending'";

		$query = $conn->query($select);
		$notification = $query->fetchAll();

		foreach ($notification as $row) {
			$status = $row['status'];
		}
		return $status;
	}

	function no_powertripping($id, $password) {
		global $conn;
		$select = "SELECT COUNT(id) as count from students where (student_id = '$id' OR card_id = '$id') AND password = '$password'";
		$query = $conn->query($select);
		$stmt = $query->fetchAll();

		foreach ($stmt as $row) {
			$count = $row['count'];
		}
		return ($count == 1) ? TRUE : FALSE;
	}

	function two_violation_count($student_id) {
		global $conn;

		$select = "SELECT 	COUNT(violation_details.id) as violations 
				   FROM 	violation_details 
				   WHERE	violation_details.student_id = '$student_id' AND 
					    	(violation_details.status = 'Violated' AND violation_details.ticket_partial = 0)";
    	$result = $conn->query($select);
    	$stmt = $result->fetchAll();

    	if (count($stmt) >= 0) {
    		foreach ($stmt as $row) {
    			$violations = $row['violations'];
    		}

    		return $violations;
    	}
	}

	function determine_gender($gender) {
		global $conn;
		$select = "SELECT gender from students where card_id = :gender OR student_id = :gender";
		$result = $conn->prepare($select);
		$result->execute(array(':gender' => $gender));
		$stmt = $result->fetchAll();

		if (count($stmt) >= 0) {
			foreach ($stmt as $row) {
				$gender = $row['gender'];
			}

			return $gender;
		}
	}

	function determine_personnel($disciplinary_personnel_id) {
		global $conn;
		
		$select = "SELECT COUNT(dp_id) as dp_id from disciplinary_personnels WHERE dp_id = $disciplinary_personnel_id";
		$result = $conn->query($select);
		$stmt = $result->fetchAll();

		foreach ($stmt as $row) {
			$disciplinary_personnel_id = $row['dp_id'];
		}

		return ($disciplinary_personnel_id == 1) ? TRUE : FALSE;
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

	function student_information($search_id) {
		global $conn;
		$select = "SELECT student_id from students where card_id = $search_id OR student_id = '$search_id'";
		$result = $conn->query($select);
		$stmt = $result->fetchAll();
		
		foreach ($stmt as $row) {
			$student_id = $row['student_id'];
		}
		return $student_id;
	}

	function violation_details_id($search_id) {
		global $conn;
		$select = "SELECT id from violation_details where student_id = '$search_id'";
		$result = $conn->query($select);
		$stmt = $result->fetchAll();

		foreach ($stmt as $row) {
			$id = $row['id'];
		}
		return $id;
	}
	
	function violation_ticket($violation_information) {
		global $conn;
		$fields = '`' . implode('`, `', array_keys($violation_information)) . '`';
		$data = '\'' . implode('\', \'', $violation_information) . '\'';

		$insert = "INSERT INTO violation_details(student_id, dp_id, remarks, valid_date, status, partial_seen, ticket, ticket_partial, violation_picture, created_at, school_term_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,)";
		$stmt = $conn->prepare($insert);
		$stmt->bindValue(1, $data);
		$stmt->bindValue(2, $data);
		$stmt->bindValue(3, $data);
		$stmt->bindValue(4, $data);
		$stmt->bindValue(5, $data);
		$stmt->bindValue(6, $data);
		$stmt->bindValue(7, $data);
		$stmt->bindValue(8, $data);
		$stmt->bindValue(9, $data);
		$stmt->bindValue(10, $data);
		$stmt->bindValue(11, $data);
		$stmt->execute();

		if ($stmt) {
			return TRUE;
		}
	}

	function school_term() {
		global $conn;

		$select = "SELECT school_term.id from school_term where status = 'Active'";
		$query = $conn->query($select);
		$stmt = $query->fetchAll();

		foreach ($stmt as $row) {
			$id = $row['id'];
		}

		if (!empty($id)) {
			return $id;
		}
	}

	function violation_of_student($id, $value) {
		global $conn;

		$insert = "INSERT INTO violations(id, violation_code) VALUES (?, ?)";
		$stmt = $conn->prepare($insert);
		$stmt->bindValue(1, $id);
		$stmt->bindValue(2, $value);
		$stmt->execute();

		if ($stmt) {
			session_unset();
			session_destroy();
		}
	}

	function number_of_notifications($student_id) {
		global $conn;

		$count = get_student_id($student_id);

		$select = "SELECT COUNT(student_id) as student_id from message_details where student_id = '$count' AND status = 'Pending'";
		$query = $conn->query($select);
		$stmt = $query->fetchAll();

		foreach ($stmt as $row) {
			$id = $row['student_id'];
		}
		return $id;
	}

	function update_ticket_flagged($student_id) {
		global $conn;

		$update = "UPDATE violation_details SET ticket_partial = 1 WHERE student_id = '$student_id' AND status = 'Violated'";

		$result = $conn->query($update);
	}
?>