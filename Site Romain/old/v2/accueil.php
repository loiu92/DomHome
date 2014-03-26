<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="fr"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="fr"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="fr"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr"> <!--<![endif]-->
<head>
  <meta charset="iso-8859-15">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>DomHome</title>
  <link rel="stylesheet" href="style-accueil.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<html>
<!--header-->
<?php
include ('header.html');
if(isset($_GET['categorie']))
{}
else
{$_GET['categorie']='Favoris';} ?>

<!--menus-->
<body>
<div id='body'>
	<div id='liste-categories'>
<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=domhome', 'root','');
}
catch(exeption $e)
{
	die('erreur : '. $e->getMessage());
}

$req = $bdd->query('Select nom from categories');
while ($donnees = $req->fetch())
{
?>
<div class='categorie'>
<?php echo '<a href="accueil.php?categorie='.$donnees['nom'].'"> '.$donnees['nom'].'</a>'; ?>
</div>
<?php
}
$req->closeCursor();
?>
	</div>
<!--liste des appareils - états - controles-->
	<div id='appareils-control'>
		<div id='fond-liste-appareils'>
		</div>
		<div id='liste-appareils'>
			<div id='nom-categorie-appareils'>
<?php echo $_GET['categorie'];?>
			</div>
		
		<?php
$req = $bdd->prepare('Select appareil from appareils where groupe = ?');
$req->execute(array($_GET['categorie']));

while ($donnees = $req->fetch())
{
?>
<div class='appareils'>
<?php
echo $donnees['appareil'];
?>
<img class='int' src='int.png'>
</div>
<?php
}
$req->closeCursor();
?>
		</div>
		<div id='fond-etat-appareils'>
		</div>
		<div id='etat-appareils'>
			<div id='etat'>
<p>etat </p>
			</div>
<?php
$req = $bdd->prepare('Select etat from appareils where groupe=?');
$req->execute(array($_GET['categorie']));

while ($donnees = $req->fetch())
{
?>
<div class='etat'>
<?php
if ($donnees['etat'] == 1)
{
?>
<img src='on.png'>
<?php 
}
else 
{
?>
<img src='off.png'>
<?php
}
?>
</div>
<?php
}
$req->closeCursor();
?>

		</div>
		</div>
</div>
</body>
<?php
include ('footer.html');
?>
</html>