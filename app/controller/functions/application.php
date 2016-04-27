<?php  
	function protect_page() {
		if (!initialize_token()) {
			header('Location: index.php');
			exit();
		}
	}

	function protect_widget_page() {
		if (!initialize_token()) {
			header('Location: ../../../index.php');
		}
	}

	function revert_page_protection() {
		if (initialize_token()) {
			session_unset();
			session_destroy();
			header('Location: index.php');
			exit();
		}
	}
?>