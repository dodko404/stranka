<?php

$servername = "localhost";
$username = "majkl";
$password = "zErUKRNTsTQtJecF";
$db = "balun_uzivatelia";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);	 

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$user = $_POST['meno'];
		$heslo = md5($_POST['heslo']);
		$sql = 'SELECT * FROM uzivatelia WHERE login="'.$user.'" AND heslo="'.$heslo.'"';
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			$row = $result->fetch_assoc() ;


			session_start();

			  $_SESSION["rola"] = $row["rola"];
			  $_SESSION["meno"] = $row["meno"];
			  $_SESSION["user"] = $user;
			  header('Location: index.php');
		  } else {
			  echo 
			  '<div class="alert alert-danger" role="alert">
			  Nesprávne Meno alebo Heslo
			</div>';
		  }
		 
		
		// $pouzivatelia = file('uzivatelia.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		// $prihlasenie = [];

		// foreach ($pouzivatelia as $pouzivatel) {
		// 	list($meno, $heslo) = explode('::',$pouzivatel);
		// 	$prihlasenie[$meno] = $heslo;
		// }

		// foreach ($prihlasenie as $user => $heslo) {
			
		// 	if ( $_POST['meno'] == $user) {
		// 		if ( $_POST['heslo'] == $heslo) {
		// 			session_start();
		// 			$_SESSION["user"] = $user;
		// 			header('Location: index.php');
		// 		}
		// 	}		
		// }
	} else {
 		
	}
	$conn->close();
?>


<section class="pt-5">
	<div class="card card-login mx-auto mt-5">
		<h4 class="text-center mt-3">Prihlásenie</h4>
		<div class="card-body">
			<div class="collapse alert alert-danger pb-0" id="chybaPrihlasenia">
				<h4 class="alert-heading">Chyba prihlásenia</h4>
				<p>Skontrolujte či ste prosím zadali správne meno alebo heslo.</p>				
			</div>

			<form class="was-validated" action="" method="POST" autocomplete="off">
				<div class="form-group">
					<label for="menoUzivatela" class="col-form-label">Meno</label>
					<div class="input-group mb-2">
						<input type="text" class="form-control" id="menoUzivatela" name="meno" value="" required autocomplete="off" pattern="[^ ][\D|0-9]{3,9}">
						<div class="invalid-feedback">Prosím zadaj meno</div>
					</div>
				</div>

				<div class="form-group">
					<label for="hesloUzivatela" class="col-form-label">Heslo</label>
					<div class="input-group mb-2">
						<input type="password" class="form-control" id="hesloUzivatela" name="heslo" required autocomplete="off" pattern="[^ ][\D|0-9]{3,9}">
						<div class="invalid-feedback">Prosím zadaj heslo</div>
					</div>
				</div>
				
				<input type="submit" value="Prihlásiť sa" class="btn btn-dark value container-fluid mt-4">

			</form>

		</div>
	</div>
</section>
