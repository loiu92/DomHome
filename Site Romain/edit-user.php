<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');
$app=0;

// Appareils accesible
$req=$bdd->query('SELECT A.id FROM appareils A
				INNER JOIN acces_appareils B
					ON A.id=B.idappareil
				WHERE B.idcompte='.$_POST['user']);
while ($donnees=$req->fetch())
{
	$app++;
	if (!isset($_POST[$app]))
	{	
		$requ=$bdd->prepare('UPDATE acces_appareils SET acces=0 WHERE idappareil= :idapp AND idcompte= :idcompte');
		$requ->execute(array('idapp'=>$donnees['id'], 
							'idcompte'=>$_POST['user']));
	}
	else
	{
		$requ=$bdd->prepare('UPDATE acces_appareils SET acces=1 WHERE idappareil= :idapp AND idcompte= :idcompte');
		$requ->execute(array('idapp'=>$donnees['id'], 
							'idcompte'=>$_POST['user']));
	}
}

// groupe accesible 
$grp=100000;
$req=$bdd->prepare('SELECT id, Acces, idgroupe FROM acces_groupes_standard WHERE idcompte=:idcompte');
$req->execute(array('idcompte'=>$_POST['user']));
while ($donnees=$req->fetch())
{
	$idags=$donnees['id'];
	$groupe=$donnees['idgroupe'];
	$grp++;
	if (isset($_POST[$grp]))
	{
		if ($donnees['Acces']==0)
		{
			$req1=$bdd->prepare('SELECT MAX(rang) maxrang FROM order_groupes WHERE idcompte= :idcompte');
			$req1->execute(array('idcompte'=>$_POST['user']));
			while ($donnees=$req1->fetch())
			{
				$nrang=($donnees['maxrang']+1);
				$req2=$bdd->prepare('INSERT INTO order_groupes VALUES(\'\', :idgroupe, :idcompte, :rang)');
				$req2->execute(array(	
									'idgroupe'=>$groupe,
									'idcompte'=>$_POST['user'],
									'rang'=>$nrang));
				echo 'done';
			}
		}
		$requ=$bdd->prepare('UPDATE acces_groupes_standard SET Acces=1, Visible=1 WHERE id= :id ');
		$requ->execute(array('id'=>$idags));
	}
	else
	{
		if($donnees['Acces']==1)
		{
			$req1=$bdd->prepare('SELECT rang FROM order_groupes WHERE idgroupe=:idgroupe AND idcompte= :idcompte'); 
			$req1->execute(array(
								'idgroupe'=>$groupe,
								'idcompte'=>$_POST['user']));
			while($donnees=$req1->fetch())
			{
				$req2=$bdd->prepare('DELETE FROM order_groupes WHERE idgroupe= :idgroupe AND idcompte= :idcompte'); 
				$req2->execute(array(
								'idgroupe'=>$groupe,
								'idcompte'=>$_POST['user']));
			
				$rangin=$donnees['rang'];
				$rangapp=$rangin;
				$req2=$bdd->prepare('SELECT id AS idog FROM order_groupes 
									WHERE idcompte= :idcompte 
									AND rang> :rang
									ORDER BY rang');
				$req2->execute(array(
									'idcompte'=>$_POST['user'],
									'rang'=>$rangin));
				while ($donnees=$req2->fetch())
				{
					$req3=$bdd->prepare('UPDATE order_groupes SET rang= :rang WHERE id = :id');
					$req3->execute(array(
										'rang'=>$rangapp,
										'id'=>$donnees['idog']));
					$rangapp++;
					echo $donnees['idog'];
				}
				}
		 }
			$requ=$bdd->prepare('UPDATE acces_groupes_standard SET Acces=0, Visible=0 WHERE id= :id ');
			$requ->execute(array('id'=>$idags));
		}
}
header ('location: reglage-admin.php?page=editcompte');