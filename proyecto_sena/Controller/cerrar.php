<?php
		session_start();
		session_unset();
		session_destroy();
		header("Location: ../View/inicio_Sesion_Usuario.php");
		exit();
?>