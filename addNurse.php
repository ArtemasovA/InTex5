<?php
	require("dbContext.php");
	
	AddNurse($_POST["name"],$_POST["departments"],$_POST["shifts"]);

	header('Location: index.php'); exit();
?>