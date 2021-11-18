<?php 
	include'../../assets/header.php';
	include'../../assets/menu.php';
	include'../../assets/rozne.php';
	date_default_timezone_set("Europe/Bratislava");


	$servername = "localhost";
	$username = "majkl";
	$password = "zErUKRNTsTQtJecF";
	$db = "balun_prispevky";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $db);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT * FROM prispevky";
	$result = $conn->query($sql);
	$data = [];
	
	if ($result->num_rows > 0) {
		// output data of each row
		$data = $result->fetch_all(MYSQLI_ASSOC);
		

		//echo "id: " . $row["id"]. " - Meno: " . $row["meno"]. " - Prispevok: " . $row["prispevok"]." - Cas: " . $row["cas"]. "<br>";
		
	} else {
		echo "0 results";
	}


	
	$chyba = "";
	$alert = "alert-danger";
	$meno = $sprava = "";
	$message = "Pozor!";

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		if (empty(kontrola($_POST['name']))) {
			$chyba .= "Meno nie je vyplnené<br>";
		}

		if (empty(kontrola($_POST['content']))) {
			$chyba .= "Správa nie je vyplnená<br>";
		}

		if (empty(kontrola($_POST['content']))) {
			$chyba .= "Správa nie je vyplnená<br>";
		}
		if (kontrola($_POST['odpoved']) != $_POST['spravnaOdpoved']) {
			$chyba .= "Prázdna alebo nesprávna odpoveď na otázku<br>";
		}

		if( empty($chyba) ){ 

			$suborPrispevky = fopen('prispevky.csv', 'a');

			$novyPrispevok[] = $_GET['pocet'] + 1; 
			$novyPrispevok[] = kontrola($_POST['name']); 
			$novyPrispevok[] = kontrola($_POST['content']);
			$novyPrispevok[] = date('Y-m-d H:i:s', time() ); 

			fputcsv($suborPrispevky, $novyPrispevok, ';');
			//fclose($suborPrispevky);
			$chyba .= "save";

		}else{

			$meno = kontrola($_POST['name']);
			$sprava = kontrola($_POST['content']);
		}
		
	}

	$suborCaptcha = file('captcha.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	for ($i=0; $i < count($suborCaptcha) ; $i+=2){

		$antiSpam[str_replace('odpoved: ','',$suborCaptcha[$i+1])] = str_replace('otazka: ','', $suborCaptcha[$i]);
	}

	$antiSpamKluc = array_rand($antiSpam);
	//echo $antiSpamKluc;


	$suborPrispevky = fopen("prispevky.csv", "r");

	while($prispevok = fgetcsv($suborPrispevky,1000,';')){
		$prispevky[] = $prispevok;
	}

	fclose($suborPrispevky);
	$prispevky = array_reverse($prispevky);

	if( !empty($chyba) ){
		if( $chyba=='save' ){

			$alert = "alert-success";
			$chyba = "Tvoj príspevok bol uložený";
			$message = "Ďakujeme!";
		}
		?>
		<div class="alert <?php echo $alert ?> alert-dismissible fade show" role="alert">
			<strong><?php echo $message; ?></strong> <?php echo $chyba; ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
	 	</div>
<?php
	}

?>
<section>
	<h1 class="py-3 text-center">Blog</h1>

	<div class="container">
		<form class="was-validated" action="?pocet=<?php echo count($prispevky) ?>" method="post"> 
			<div class="form-group"> 
				<label for="i1">* Meno</label> 
					<input type="text" name="name" class="form-control" pattern="[^ ][\D|0-9]{3,9}" placeholder="Autor správy" value="<?php echo $meno ?>" required> 
				<div class="invalid-feedback">Prosím vyplňte túto položku!</div>
			</div> 

			<div class="form-group"> 
				<label for="i2">* Správa</label> 
				<textarea name="content" class="form-control" rows="5" placeholder="Text správy" required><?php echo $sprava ?></textarea> 
				<div class="invalid-feedback">Prosím zedajte text správy!</div>
			</div> 
			<div>
				<label for="i3"><sma11><b>Antispam: </b><?php echo $antiSpam[$antiSpamKluc] ?></sma11></label> 
			</div>	
			<div class="row d-flex"> 
				<div class="form-group col-7"> 		
					<input type="text" name="odpoved" class="form-control" pattern="<?php echo $antiSpamKluc; ?>" placeholder="Odpoveď na otázku" required> 
					<div class="invalid-feedback">Prosím odpovedaj správne na otázku!</div>
				</div> 
				<div class="form-group col-5 d-flex justify-content-end align-self-baseline"> 
					<input type="reset" value="Resetovať" class="btn btn-outline-secondary mr-3">
					<input type="submit" value="Odoslať" class="btn btn-primary">
				</div> 
			</div> 		

			<input type="hidden" name="spravnaOdpoved" value="<?php echo $antiSpamKluc ?>">

		</form> 
	</div>
	<hr>
	<div class="container">
		<?php 



			foreach ($data as $prispevok) {
				//$datum = strtotime($prispevok[3]);
				$datumTxt = $prispevok ['cas'] ; //date('j. ', $datum) .$mesiace[date('n', $datum) - 1]. date(' Y H:i', $datum); 
			
		 ?>	
			<h4><?php echo $prispevok['meno'] ?></h4>
			<small><i> Odoslane: <?php echo $datumTxt ?></i></small>
			<p>
				<?php echo prelozBBCode(nl2br($prispevok['prispevok'])) ?>
			</p>
			<hr>
		<?php 

		
			}
			$conn->close();
		 ?>
	</div>
</section>

<?php 
	include'../../assets/footer.php';

?>
