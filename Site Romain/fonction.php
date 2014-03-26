<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

	$requ=$bdd->query('SELECT id FROM comptes WHERE usert="admin"');
	while($donnees=$requ->fetch())
	{
		$req=$bdd->query('SELECT MAX(rang) rang FROM order_groupes');
		while ($donnees=$req->fetch())
		{
			echo $donnees['id'];
		}
	}