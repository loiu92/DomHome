<?php
session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=domhome', 'root','');
}
catch(exeption $e)
{
	die('erreur : '. $e->getMessage());
}

$req = $bdd->prepare('Select id from comptes where nom = ?');
$req->execute(array($_SESSION['nom'])) or die(print_r($req->errorinfo()));
while ($donnees=$req->fetch())
{
$idcompte= $donnees['id']; 
}
$requ = $bdd->prepare('UPDATE groupes_nom SET nom = ? WHERE idcompte=? AND nom=?');
$requ->execute(array($_POST['nouveau-nom'], $idcompte, $_POST['groupe']));

header('location: reglage.php?page=gestion-groupe&groupe='.$_POST['nouveau-nom']);
?>