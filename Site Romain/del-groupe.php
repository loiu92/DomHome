<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

if (!isset($_SESSION['nom']))
{
	header('location: index.php?connexion=false');
}
// suppression de la composition du grou
$req=$bdd->prepare('DELETE FROM groupes_comp where idgroupe= :idgroupe');
$req->execute(array('idgroupe'=>$_GET['groupe']));

// suppresion du nom
$req = $bdd->prepare('DELETE FROM groupes_nom where id= :idgroupe');
$req->execute(array('idgroupe'=>$_GET['groupe']));

if ($_GET['type']=="groupe")
// s'il s'agit d'un groupe appartenant uniquement à l'utilisateur
{
	//suppresion du rang du groupe et mise à jour des autres rang
	$req = $bdd->prepare('SELECT rang, idcompte FROM order_groupes WHERE idgroupe= :idgroupe');
	$req->execute(array('idgroupe'=>$_GET['groupe']));
	while ($donnees=$req->fetch())
	{
		$req1 = $bdd->prepare('DELETE FROM order_groupes WHERE idgroupe= :idgroupe');
		$req1->execute(array('idgroupe'=>$_GET['groupe']));
		
		$nrang=$donnees['rang'];
		$req1 = $bdd->prepare('SELECT id FROM order_groupes WHERE idcompte= :idcompte AND rang>:rang');
		$req1->execute(array(
							'idcompte'=>$donnees['idcompte'],
							'rang'=>$donnees['rang']));
		while ($donnees=$req1->fetch())
		{
			$req2 = $bdd->prepare('UPDATE order_groupes SET rang= :rang WHERE id= :id');
			$req2->execute(array(
								'rang'=>$nrang,
								'id'=>$donnees['id']));
			$nrang++;
		}
	}
	header ('location: reglage.php?page=gestion-groupe');
}
elseif ($_GET['type']=="standard")
// s'il s'agit d'un groupe standard
{
	//suppression des acces au groupe standard
	$req = $bdd->prepare('DELETE FROM acces_groupes_standard WHERE idgroupe= :idgroupe');
	$req->execute(array('idgroupe'=>$_GET['groupe']));
	
	// modification du rang des groupes
	$req = $bdd->prepare('SELECT id, idcompte, rang FROM order_groupes WHERE idgroupe= :idgroupe');
	$req->execute(array('idgroupe'=>$_GET['groupe']));
	while ($donnees=$req->fetch())
	{
		//suppresion du rang du groupe
		$req1 = $bdd->prepare('DELETE FROM order_groupes WHERE id= :id');
		$req1->execute(array('id'=>$donnees['id']));
		
		// Ajustation du rang des autres groupes
		$nrang = $donnees['rang'];
		$req1 = $bdd->prepare('SELECT id FROM order_groupes WHERE idcompte= :idcompte AND rang>:rang');
		$req1->execute(array(		
							'idcompte'=>$donnees['idcompte'],
							'rang'=>$donnees['rang']));
		while ($donnees=$req1->fetch())
		{
			$req2 = $bdd->prepare('UPDATE order_groupes SET rang= :rang WHERE id=:id');
			$req2->execute(array(
								'rang'=>$nrang,
								'id'=>$donnees['id']));
			$nrang++;
		}
	}
header	('location: reglage-admin.php?page=all.editgroupe');	
}