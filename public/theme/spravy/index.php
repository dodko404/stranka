<?php 
	include'../../assets/header.php';
	include'../../assets/menu.php';

date_default_timezone_set("Europe/Bratislava");
?>

<section>
<?php 

	$news = glob('*.txt');
	
    
 	foreach ($news as $value) {
 		$date = strtotime(basename($value,".txt"));
 		$spravy = file($value, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ;
 ?>	
  		<h1 style="margin-top: 30px"><?= $spravy[0] ?></h1>
  		<small style="margin-bottom: 30px">Publikované: <?= date('j.n.Y H:i',$date) ?></small><br>
		<img src="images/<?= $spravy[1] ?>" alt="" style="width:250px">
	 
<?php 
	for ($i=2; $i < count($news)-2; $i++) { 
		echo '<p style="margin-bottom: 50px">'.$spravy[$i].'</p>';
	}
	
 	}
?>	

</section>

<?php 
include'../../assets/footer.php';
?>