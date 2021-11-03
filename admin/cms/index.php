<?php 

	if ($_SESSION["user"]) {
		echo $_SESSION["rola"];
	}else{
		header('Location: ../index.php');
	}

 ?>