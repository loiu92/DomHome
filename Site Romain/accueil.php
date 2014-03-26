<!DOCTYPE html>
<html>
<head>
  <meta charset="iso-8859-15">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>DomHome</title>
  <link rel="stylesheet" href="style-accueil.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
	<?php
include ('accueil-1.php');
// if (isset($_POST['relais1']))
				//recupération de l'état des intérupteurs
				$nb=0;
				$req = $bdd->prepare('SELECT  A.nom, A.id, A.onoff
				FROM appareils A
				INNER JOIN acces_appareils B 
					ON A.id = B.idappareil 
				INNER JOIN groupes_comp C
					ON B.id = C.idappareil 
				INNER JOIN groupes_nom D
					ON C.idgroupe = D.id
				WHERE D.nom= :nom 
				AND D.nom IN (Select nom from groupes_nom A
							LEFT JOIN acces_groupes_standard B ON B.idgroupe=A.id		
							WHERE A.idcompte= :idsession
							OR (B.idcompte=:idsession AND B.acces="1" AND B.visible="1"))
				AND A.id IN (SELECT idappareil FROM acces_appareils 
							WHERE idcompte=:idsession
							AND acces=1)');
				$req->execute(array(
					'nom'=>$_GET['groupe'],
					'idsession'=>$idsession)) or die(print_r($req->errorinfo()));
				while ($donnees = $req-> fetch())
				
				{
				// transformer état en valeur utilisable dans le <form>
					$name='relais'.$donnees['id'];
					if ($donnees['onoff']=="1")
					{ 		
							$etat='checked';
							$nouvetat= 0;
							$value=($donnees['id']*11);
					}
					else
					{		
						$etat="1";
						$nouvetat=1;
						$value=$donnees['id'];
					}
				// interupteur
					echo '	<form method="POST" action="accueil.php?groupe='.$_GET['groupe'].'">
						<input type="hidden" name="etat" value='.$nouvetat.'>
						<input type="hidden" name="app" value='.$donnees['id'].'>
						<input type="hidden" name='.$name.' value='.$value.'>
						<div class="etat">
						<div class="onoffswitch">
						<input type="checkbox" name="onoff" onChange="this.form.submit()" class="onoffswitch-checkbox" id="myonoffswitch'.$nb.'" '.$etat.'>
						<label class="onoffswitch-label" for="myonoffswitch'.$nb.'">
						<div class="onoffswitch-inner"></div>
						<div class="onoffswitch-switch"></div>
							</label>
						</div></div>
						<noscript><input type="submit" value="changer" /></noscript>
					</form>'; 
					$nb++;
				} 
include ('accueil-2.php');?>

</html>