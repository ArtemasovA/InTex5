<?php
	require("dbContext.php");
	
	ConnectWardWithNurse($_POST["nurse"], $_POST["ward"]);
	
	header('Location: index.php'); exit();
?>