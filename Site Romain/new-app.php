<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

if (empty($_POST['nom-nouv-app']))
{
	header ('location: reglage-admin.php?page=newdevice');
}

//ajout de l'appareil dans la base de données

$req=$bdd->prepare('INSERT INTO appareils VALUES (\'\', :nom, 0)');
$req->execute(array( 'nom'=> $_POST['nom-nouv-app']));

//lecture de l'id de l'appareil dans la base de données

$req=$bdd->prepare('SELECT id FROM appareils WHERE nom= :nom');
$req->execute(array( 'nom'=> $_POST['nom-nouv-app']));
while($donnees=$req->fetch())
{
	$id=$donnees['id'];
}

//ajout de l'appareil dans la liste des appareils accesible pas les administrateurs

$requette=$bdd->query('SELECT id FROM comptes WHERE usert="admin"');
while($donnees=$requette->fetch())
{
	$idcompte=$donnees['id'];
	$requ=$bdd->prepare('INSERT INTO acces_appareils VALUES (\'\', :idapp, :idcompte)');
	$requ->execute(array('idcompte'=> $idcompte,
							'idapp'=>$id));
}

//ajout de l'appareil dans la liste des appareils accessible par les utilisateurs séléctionné

$reque=$bdd->query('SELECT id, nom FROM comptes WHERE usert="user"');
$increase='0';
while($donnees=$reque->fetch())
{
	$increase++;
	if (isset($_POST[$increase]))
	{
		$idcompte=$donnees['id'];
		$requ=$bdd->prepare('INSERT INTO acces_appareils VALUES (\'\', :idapp, :idcompte)');
		$requ->execute(array('idcompte'=> $idcompte,
								'idapp'=>$id));
	}
}
header('location: reglage-admin.php?page=newdevice');
 ?>