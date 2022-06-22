<?php
	require("dbContext.php");
	
	AddWard($_POST["name"]);

	header('Location: index.php'); exit();
?>