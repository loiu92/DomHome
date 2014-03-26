<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=domhome', 'root','');
}
catch(exeption $e)
{
	die('erreur : '. $e->getMessage());
}

$req = $bdd->prepare('Select nom, mdp from comptes where nom = ?');
$req->execute(array($_POST['nom'])) or die(print_r($req->errorinfo()));

echo '<ul>';
while ($donnees = $req->fetch())
{
if ($donnees['mdp'] == $_POST['mdp'])
{
header('location: accueil.php');
}
else
{
header('location: mdp2.php');
}
}
echo '</ul>';



$req->closecursor();
?>

