<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

if ($_POST['suppression']==1)
{
	$req=$bdd->exec('DELETE FROM comptes WHERE id='.$_POST['user'].'');
	$req=$bdd->exec('DELETE FROM acces_appareils WHERE idcompte='.$_POST['user'].'');
	$req=$bdd->exec('DELETE FROM acces_groupes_standard WHERE idcompte='.$_POST['user'].'');
	$req=$bdd->prepare('SELECT id FROM groupes_nom WHERE idcompte= :idcompte');
	$req->execute(array('idcompte'=>$_POST['user']));
	while ($donnees=$req->fetch())
	{
		$requ=$bdd->exec('DELETE FROM groupes_nom WHERE idgroupe="'.$donnees['id'].'"');
	}
	$req=$bdd->exec('DELETE FROM groupes_nom WHERE idcompte="'.$_POST['user'].'"');
	$req=$bdd->exec('DELETE FROM order_groupes WHERE idcompte="'.$_POST['user'].'"');
}
header ('location: reglage-admin.php?page=editcompte');