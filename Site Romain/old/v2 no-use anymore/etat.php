<?php
//recupération de l'état des intérupteurs
$req = $bdd->prepare('SELECT  onoff, A.nom 
FROM appareils A
INNER JOIN acces_appareils B 
	ON B.idappareil = A.id
INNER JOIN groupes_comp C
	ON B.id = C.idappareil 
INNER JOIN groupes_nom D
	ON C.idgroupe = D.id
WHERE D.nom=?
AND D.nom IN (Select nom from groupes_nom A
		LEFT JOIN acces_groupes_standard B ON B.idgroupe=A.id		
		WHERE A.idcompte='.$idsession.'
		OR (B.idcompte='.$idsession.' AND B.acces="1" AND B.visible="1"))
AND A.id IN (SELECT idappareil FROM acces_appareils 
		WHERE idcompte='.$idsession.')');
$req->execute(array($_GET['groupe'])) or die(print_r($req->errorinfo()));
$nb=1;
while ($donnees = $req-> fetch())
{
// transformer état en valeur utilisable dans le <form>
	if ($donnees['onoff']=="1")
	{ 		$etat="checked";
			$nouvetat= 0;
	}
	else
	{		
		$etat="1";
		$nouvetat=1;	
	}
// interupteur
	echo '	<form method="POST" action="accueil.php?groupe='.$_GET['groupe'].'&amp;app='.$donnees['nom'].'&amp;etat='.$nouvetat.'">
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
} ?>