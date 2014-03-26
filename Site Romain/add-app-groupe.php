<?php 
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

if ($_GET['type'] == "stand")	
{
	// récupération de l'id du groupe 
	$req=$bdd->prepare('SELECT id FROM groupes_nom WHERE nom= :nom AND idcompte=2');
	$req->execute(array('nom' => $_GET['groupe']));
	while ($donnees = $req->fetch())
	{
		$id = $donnees['id'];
	}
	// Ajout de l'application au groupe
	$req = $bdd->prepare('INSERT INTO groupes_comp VALUES (\'\', :groupe, :appareil)');
	$req->execute(array('groupe' => $id,'appareil'=> $_GET['app']));
	
	header('location: reglage-admin.php?page=all.editgroupe&groupe='.$_GET['groupe'].'');
}
else  	
{
// recupération id de l'utilisateur actuel
	$req = $bdd->prepare('Select id from comptes where nom = ?');
	$req->execute(array($_SESSION['nom'])) or die(print_r($req->errorinfo()));
	while ($donnees=$req->fetch())
	{
		$idcompte= $donnees['id']; 
	}

// récupération de l'id du groupe 
	$req=$bdd->prepare('SELECT id FROM groupes_nom WHERE nom= :nom AND idcompte= :idcompte');
	$req->execute(array('nom' => $_GET['groupe'], 'idcompte' => $idcompte));
	while ($donnees = $req->fetch())
	{
		$id = $donnees['id'];
	}

// Ajout de l'application au groupe
	$req = $bdd->prepare('INSERT INTO groupes_comp VALUES (\'\', :groupe, :appareil)');
	$req->execute(array('groupe' => $id,'appareil'=> $_GET['app']));

	header('location: reglage.php?page=gestion-groupe&groupe='.$_GET['groupe'].'');
}