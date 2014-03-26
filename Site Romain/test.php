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
// $test servant à vérifier qu'il y a bien un compte avec ce nom.
$test=1;
$req = $bdd->prepare('Select nom, mdp, usert from comptes where nom = :nom');
$req->execute(array('nom'=>$_POST['nom'])) or die(print_r($req->errorinfo()));
while ($donnees = $req->fetch())
{
	if ($donnees['mdp'] == $_POST['mdp'])
	{
		$_SESSION['mdp']=$_POST['mdp'];
		$_SESSION['nom']=$_POST['nom'];
		$_SESSION['usert']=$donnees['usert']; 
		$test=0;
		header('location: accueil.php');
	}
	else
	{
		$test=0;
		header('location: index.php?connexion=false');
	}
}
if ($test!=0)
{
	header('location: index.php?connexion=false');
}
?>

