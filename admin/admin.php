<?php 
include'../public/assets/header.php';
include'adminNav.php';
?>

<div class="container py-5">


	<?php
	$chyba="";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

     $uzivatelia = file('uzivatelia.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
     $prihlasenie = [];
        foreach ($uzivatelia as $uzivatel) {
            list($k,$h) = explode('::', $uzivatel);
            $prihlasenie[$k] = $h;
                   }

        if($_POST['password'] === $prihlasenie[$_POST['email-address']])
        {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
 <strong> Prihlasený</strong> <?php echo $chyba; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
        } 
        else if (!$prihlasenie[$_POST['email-address']])
        {
            //uzivatel neexistuje
        }
        else {
            //nespravne heslo
        }
    }
 ?>


	<div class="text-center">
		<h3>Zadaj svoje prihlasovacie údaje</h3>
	</div>

	<div class="py-5">
		<form action="index.php" method="POST">
  				<div class="form-group row was-validated">
    				<label for="formGroupExampleInput">Email</label>
    				<input type="text" class="form-control" id="formGroupExampleInput" name="meno
    				" placeholder="Jozkomrkva123@lietadla.com">
    				<div class="invalid-feedback">
    					Zadaj email
    				</div>
  				</div>

  				<div class="form-group row was-validated">
    				<label for="inputPassword5">Heslo</label>
					<input type="password" id="inputPassword5" name="heslo"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,}$" class="form-control" aria-describedby="passwordHelpBlock" placeholder="nepoviemti">

					<div class=" invalid-feedback">
					Zadaj heslo 
					</div>
				</div>

		</form>

		<div class="form-check py-3">
  			<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
  			<label class="form-check-label" for="flexCheckDefault">
   				 Zapamätať prihlásenie
  			</label>
		</div>

		<button type="submit" class="btn btn-primary ">Potvrdiť</button>

	</div>	
</div>

<?php 
include'../public/assets/footer.php';
?>