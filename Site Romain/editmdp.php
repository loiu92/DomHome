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
if ($_POST['new-mdp-1']==$_POST['new-mdp-2'])
{

$req = $bdd->prepare('UPDATE comptes SET mdp = :nvmdp WHERE nom = :nom');
$req->execute(array(
	'nvmdp'=> $_POST['new-mdp-1'],
	'nom'=> $_SESSION['nom']
	));
$_SESSION['mdp']=$_POST['new-mdp-1'];
header ('location: reglage.php?page=general&amp;modif=fait');

}
else
{
header ('location: reglage.php?page=general&amp;modif=erreur');
}
$req->closecursor();
?>