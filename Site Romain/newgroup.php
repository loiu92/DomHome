<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

// récuperation id du compte actuel
$req = $bdd->prepare('SELECT id FROM comptes WHERE nom = :nom');
$req->execute(array('nom'=>$_SESSION['nom']));
while($donnees = $req->fetch())
{
	$sessionid = $donnees['id'];
}

// création du groupe
$req = $bdd->prepare('INSERT INTO groupes_nom (id, nom, idcompte) VALUES(\'\', :nom, :compte)');
$req->execute(array(
			'nom'=> $_POST['nom'],
			'compte'=> $sessionid,));

// récupération de l'id du nouveau groupe
$req=$bdd->prepare('SELECT id FROM groupes_nom WHERE nom= :nom');
$req->execute(array('nom'=>$_POST['nom']));
while($donnees = $req->fetch())
{
	$groupe = $donnees['id'];
}

// composition du groupe	
$requ=$bdd->query('SELECT id FROM appareils');
$inc="0";
while($donnees = $requ->fetch())
{
	$inc++;
	if(!empty($_POST[$inc]))
	{
		$req=$bdd->prepare('INSERT INTO groupes_comp(id, idgroupe, idappareil)  VALUES(\'\', :groupe, :app)');
		$req->execute(array(
			'app'=> $donnees['id'],
			'groupe'=> $groupe,));
	}
} 
header ('location:reglage.php?page=gestion-groupe');
?>