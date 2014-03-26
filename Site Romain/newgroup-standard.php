<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

if (preg_match("#^[a-zA-z0-9]{3,}$#", $_POST['nom']))
{
// Création du groupe
	$req = $bdd->prepare('INSERT INTO groupes_nom (id, nom, idcompte) VALUES(\'\', :nom, :compte)');
	$req->execute(array(
		'nom'=> $_POST['nom'],
		'compte'=> "2",
		));
// récupération de son id 
	$req=$bdd->prepare('SELECT id FROM groupes_nom WHERE nom=?');
	$req->execute(array($_POST['nom']));
	while($donnees = $req->fetch())
	{
		$groupe = $donnees['id'];
	}

// rang du groupe pour les administrateurs
	$requ=$bdd->query('SELECT id FROM comptes WHERE usert="admin"');
	while($donnees=$requ->fetch())
	{
		$id=$donnees['id'];
		$req=$bdd->query('SELECT MAX(rang) rang FROM order_groupes');
		while ($donnees=$req->fetch())
		{
			$rang=($donnees['rang']+1);
			$reque=$bdd->prepare('INSERT INTO order_groupes VALUES (\'\', :idgroupe, :idcompte, :rang)');
			$reque->execute(array(
							'idgroupe'=>$groupe,
							'idcompte'=>$id,
							'rang'=>$rang));
		}
	}

// Composition du groupe 
	$requ=$bdd->query('SELECT id FROM appareils	');
	$inc="0";
	while($donnees = $requ->fetch())
	{
		$inc++;
		if($_POST[$inc]=="1")
		{
			$req=$bdd->prepare('INSERT INTO groupes_comp(id, idgroupe, idappareil)  VALUES(\'\', :groupe, :app)');
			$req->execute(array(
				'app'=> $donnees['id'],
				'groupe'=> $groupe,));
		}
	}

// acces au groupe pour les administrateurs
	$req=$bdd->query('SELECT id FROM comptes WHERE usert="admin"');
	while ($donnees=$req->fetch())
	{
		$requ=$bdd->prepare('INSERT INTO acces_groupes_standard (id, idgroupe, idcompte, acces, visible) VALUES (\'\', :idgroupe, :idcompte, 1, 1)');
		$requ->execute(array(
						'idgroupe'=>$groupe,
						'idcompte'=>$donnees['id']));
	}
	header ('location:reglage-admin.php?page=all.editgroupe');
	
//gestion des utilisateur ayant acces aux groupes
	$nb=1;
	$req = $bdd->query('SELECT id FROM comptes WHERE usert="user"');
	while ($donnees=$req->fetch())
	{
		$usernb='user'.$nb;
		if (isset($_POST[$usernb]))
		{
			$requ=$bdd->prepare('INSERT INTO acces_groupes_standard (id, idgroupe, idcompte, acces, visible) VALUES (\'\', :idgroupe, :idcompte, 1, 1)');
			$requ->execute(array(
						'idgroupe'=>$groupe,
						'idcompte'=>$donnees['id']));
		}
		else
		{
			$requ=$bdd->prepare('INSERT INTO acces_groupes_standard (id, idgroupe, idcompte, acces, visible) VALUES (\'\', :idgroupe, :idcompte, 0, 0)');
			$requ->execute(array(
					'idgroupe'=>$groupe,
					'idcompte'=>$donnees['id']));
		}
		$nb++;
	}
}
else
{
	echo 'erreur';
}	?>
