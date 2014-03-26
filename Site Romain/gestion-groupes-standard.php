<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

$req=$bdd->prepare('SELECT id FROM comptes WHERE nom=:nom');
$req->execute(array('nom'=>$_SESSION['nom']));
while ($donnees=$req->fetch())
{
	$idcompte=$donnees['id'];
}
$inc=0;
$req=$bdd->prepare('SELECT B.id, nom, visible FROM groupes_nom A
					INNER JOIN acces_groupes_standard B
						ON A.id=B.idgroupe
					WHERE B.idcompte= :idcompte
					AND acces="1"');
$req->execute(array('idcompte'=>$idcompte));
while ($donnees=$req->fetch())
{
	if(isset($_POST[$inc]))
	{
		$req1=$bdd->prepare('UPDATE acces_groupes_standard SET Visible="1" WHERE id= :id');
		$req1->execute(array('id'=>$donnees['id']));
	}
	else
	{
		$req1=$bdd->prepare('UPDATE acces_groupes_standard SET Visible="0" WHERE id= :id');
		$req1->execute(array('id'=>$donnees['id']));
	}
	$inc++;
}
header ('location: reglage.php?page=groupes-standards');