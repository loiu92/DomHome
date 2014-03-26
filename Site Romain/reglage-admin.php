<head>
  <meta charset="iso-8859-15">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>DomHome</title>
  <link rel="stylesheet" href="style-accueil.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<!--header + session start + bdd connexion-->
<html>
<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

include ('header.php');

// si aucune sous page n'est séléctionnée par l'utilisateur allé à la page "modifier un compte" 
if (!isset($_GET['page']))
{ 
	$_GET['page']='editcompte';
}?>
<body>
<div class="body">
	<div id="body-contenu">
		<div id="nav-reglage-fond">
			<div id="nav-reglage"><?php
				if ($_SESSION['usert']=='admin')
				{ ?>
					<p class="session-title">Gestion interne</p>
					<p class='reglages'>
					<a href='reglage-admin.php?page=editcompte'>Modifier un compte</a></br>
					<a href='reglage-admin.php?page=newcompte'>Nouvel utilisateur</a> </br>
					<a href='reglage-admin.php?page=all.editgroupe'>Modifier les groupes standard</a></br>
					<a href='reglage-admin.php?page=all.newgroupe'>Creer un nouveau groupe standard</a></br>
					<a href='reglage-admin.php?page=newdevice'>Nouvel appareil</a></p></br><?php
				}
				else
				{	}?>
			</div>
		</div>
		<div id='reglage-body'>
		
<?php
if($_GET['page']=='editcompte' AND $_SESSION['usert']=='admin' AND !isset($_GET['act']) AND !isset($_GET['user']))
{?>
	<p class="session-title"> Modifier un compte</p></br>
	<p>Liste des utilisateurs</p>
	<table class="table-user">
		<tr>
			<th> Nom du compte</th>
			<th> Type d'utilisateur</th>
			<th> Gestion du compte</th>
		</tr><?php
	$req=$bdd->query('SELECT id, nom, usert FROM comptes where nom != "standard" ORDER BY usert' );
	while ($donnees= $req->fetch())
	{
		echo 
			'<tr> 	
				<td>'.$donnees['nom'].'</td>
				<td>'.$donnees['usert'].'</td>
				<td>';
					if ($donnees['usert']=="user")
					{
					echo	'<a href="reglage-admin.php?page=editcompte&amp;act=edit&amp;user='.$donnees['id'].'"><img src="images/editer.png" title="modifier les appareils et groupes standard auquels '.$donnees['nom'].' a acces"></a>';
					}
					echo	'<a href="reglage-admin.php?page=editcompte&amp;act=sup&amp;user='.$donnees['id'].'"><img src="images/supprimer.png" title="Supprimer le compte : '.$donnees['nom'].'"></a>
				</td>
			</tr>';
	}
	echo '</table>';
}
elseif($_GET['page']=='editcompte' AND $_SESSION['usert']=='admin' AND $_GET['act']=="edit" AND isset($_GET['user']))
{
	$req=$bdd->query('SELECT nom FROM comptes WHERE id='.$_GET['user'].'');
	while ($donnees=$req->fetch())
	{
		$nom=$donnees['nom'];
	}
	echo '<p class="session-title"> Modifier le compte de '.$nom.'</p></br>
	<form method="post" action="edit-user.php">
		<input type="hidden" name="user" value="'.$_GET['user'].'">
		<table class="table-edit-user">
			<tr>
				<td>
					<p class="title-edituser">Appareils controlable</p></br>';
					$app=0;
					$req=$bdd->query(' SELECT B.acces, A.nom FROM appareils A
										INNER JOIN acces_appareils B
											ON A.id=B.idappareil
										WHERE B.idcompte='.$_GET['user']);
					
					while ($donnees=$req->fetch())
					{
						if ($donnees['acces']==1)
						{
							$etat="checked";
						}
						else
						{
							$etat="notchecked";
						}
						$app++;
						echo '<label class="nom-app-edituser">'.$donnees['nom'].'</label>
							<div class="checkbox-edituser">
								<input type="checkbox" name="'.$app.'" class="checkbox-checkbox" id="'.$app.'" '.$etat.'>
								<label class="checkbox-label" for="'.$app.'">
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div>';
					}
				echo'</td>
				<td>
					<p class="title-edituser">Groupes standards accesible</p></br>';
				$grp=100000;
				$req=$bdd->query('SELECT A.acces, B.nom FROM acces_groupes_standard A
								INNER JOIN groupes_nom B
									ON A.idgroupe=B.id
								WHERE A.idcompte='.$_GET['user'].'');
				while ($donnees=$req->fetch())
				{
					$grp++;
					if ($donnees['acces']==1)
					{
						$etat="checked";
					}
					else
					{
						$etat=1;
					}
					echo '
					<label class="nom-app-edituser">'.$donnees['nom'].'</label>
					<div class="checkbox-edituser">
						<input type="checkbox" name="'.$grp.'" class="checkbox-checkbox" id="'.$grp.'" '.$etat.'>
						<label class="checkbox-label" for="'.$grp.'">
							<div class="checkbox-inner"></div>
							<div class="checkbox-switch"></div>
						</label>
					</div>';
				}
				echo'</td>
			</tr>
		</table>
		<input type="submit" value="Valider">
	</form>';
}
elseif($_GET['page']=='editcompte' AND $_SESSION['usert']=='admin' AND $_GET['act']=='sup' AND isset($_GET['user']))
{
		$req=$bdd->query('SELECT nom, usert FROM comptes WHERE id='.$_GET['user'].'');
		while ($donnees=$req->fetch())
		{
			$nom=$donnees['nom'];
			$usert=$donnees['usert'];
		}
		if ($usert=="admin")
		{
			$req=$bdd->query('SELECT COUNT(id) count FROM comptes where usert="admin"');
			$donnees=$req->fetch();
			$nbadmin=$donnees['count'];
			if ($nbadmin<2)
			{
				echo '<p class="session-title"> Supprimer le compte de  '.$nom.'</p></br>
				<p>Cette action n\'est pas possible.</br>
				Vous ne pouvez pas supprimer le dernier comptes administrateur.';
			}
		}
		else
		{
			echo '<p class="session-title"> Supprimer le compte de  '.$nom.'</p></br>
				<p>Attention, vous vous appretez a supprimer le compte '.$nom.'.</br>
				L\'integralite des donnees liees a ce compte seront definitivement supprimees et ne pouront etre recuperee.</p>
				<form method="post" action="delete-compte.php">
					<input type="hidden" name="suppression" value="1">
					<input type="hidden" name="user" value="'.$_GET['user'].'">
					<input class="boutonsubmit" type="submit" value="Valider la suppression">
				</form>';
		}
}
elseif($_GET['page']=='newcompte' AND $_SESSION['usert']=='admin' AND ((!isset($_GET['p'])) OR $_GET['p']==1)) 
{ ?>
<!-- page 1 du formulaire "nouveau compte"-->
	<p class="session-title"> Creer un nouveau compte d'utilisateur 1/3</p>
		<form action="reglage-admin.php?page=newcompte&amp;p=2" method="post">
			<label>Nom du compte</label><input type="text" name="nom-nouv-compte" autocomplete="off"></br>
			<label>Mot de passe</label><input type="password" name="password" value=""></br>
			<label>Type d'utilisateur</label><SELECT name="usert">
										<option>Utilisateur</option>
										<option>Administrateur</option>
										 </select></br>
			<input type="submit" value="Valider">				
		</form><?php 
}
elseif($_GET['page']=='newcompte' AND $_SESSION['usert']=='admin' AND isset($_GET['p']) AND $_GET['p']==2 AND $_POST['usert']=="Administrateur") 
{
// page 2, création du compte s'il s'agit d'un administrateur
	if (preg_match("#^[^ .-][a-zA-Z0-9]{3,}$#",$_POST['nom-nouv-compte']))
	{
//création du compte
		$req=$bdd->prepare('INSERT INTO comptes VALUES (\'\', :nom, :mdp, "admin")');
		$req->execute(array('nom'=>$_POST['nom-nouv-compte'],'mdp'=>$_POST['password']));
//recupération de l'id du compte
		$req=$bdd->query('SELECT id FROM comptes WHERE nom="'.$_POST['nom-nouv-compte'].'"');
		while ($donnees=$req->fetch())
		{
			$idnouvcompte=$donnees['id'];
		}
//création de l'accès aux appareils
		$req=$bdd->query('SELECT id FROM appareils');
		while($donnees=$req->fetch())
		{
			$requ=$bdd->exec('INSERT INTO acces_appareils VALUES (\'\', '.$donnees['id'].', '.$idnouvcompte.', 1)');
		}
//création de l'accès aux groupes standard
		$req=$bdd->query('SELECT id FROM groupes_nom WHERE idcompte="2"');
		while ($donnees=$req->fetch())
		{
			$requ=$bdd->exec('INSERT INTO acces_groupes_standard VALUES (\'\', '.$donnees['id'].', '.$idnouvcompte.', "1", "1")');
		}
		echo '<p class="session-title"> Compte cree</p></br>
			<p>Nom du compte :'.$_POST['nom-nouv-compte'].'</br>
			Mot de passe :'.$_POST['password'].'</br>
			Type d\'utilisateur :'.$_POST['usert'].'</p></br';
	}	
	else 	{
		echo 'erreur, aucun nom de compte';}	
}
elseif($_GET['page']=='newcompte' AND $_SESSION['usert']=='admin' AND isset($_GET['p']) AND $_GET['p']==2 AND $_POST['usert']=="Utilisateur") 
{ ?>
<!-- page 2 du formulaire "nouveau compte" s'il s'agit d'un  utilisateur-->
	<p class="session-title"> Creer un nouveau compte d'utilisateur 2/3</p><?php
// Si aucun nom de compte
	if (!preg_match("#^[^ .-][a-zA-Z0-9]{3,}$#",$_POST['nom-nouv-compte']))
	{
		echo 'erreur, aucun nom de compte ou nom trop court';
	}
	else
	{?>
		<form action="reglage-admin.php?page=newcompte&amp;p=3" method="post">
<!--transmisions des données de la page 1-->
		<?php echo '<input type="hidden" name="nom-nouv-compte" value="'.$_POST['nom-nouv-compte'].'">
				<input type="hidden" name="password" value="'.$_POST['password'].'">
				<input type="hidden" name="usert" value="'.$_POST['usert'].'">
				<p>Liste des groupes groupes accesible par l\'utilisateur</p>';
//formulaire page 2
		$req=$bdd->query('SELECT nom FROM groupes_nom WHERE idcompte=2');
		while( $donnees=$req->fetch())
		{
			echo '<label>'.$donnees['nom'].'</label>
		<div class="checkbox-acces-gs">
		<input type="checkbox" name="'.$donnees['nom'].'" class="checkbox-checkbox" id="'.$donnees['nom'].'">
		<label class="checkbox-label" for="'.$donnees['nom'].'">
			<div class="checkbox-inner"></div>
			<div class="checkbox-switch"></div>
		</label>
		</div></br>';
		} ?>
				<input type="submit" value="Valider">				
		</form>	<?php 
	}
}
elseif($_GET['page']=='newcompte' AND $_SESSION['usert']=='admin' AND isset($_GET['p']) AND $_GET['p']==3)
{ ?>
	<p class="session-title"> Creer un nouveau compte d'utilisateur 3/3</p>
	<form action="reglage-admin.php?page=newcompte&amp;p=4" method="post"><?php 
// identification des groupes standards accessible  
	$reque=$bdd->query('SELECT nom FROM groupes_nom WHERE idcompte=2');
	while($donnees=$reque->fetch())
	{
		if (isset($_POST[$donnees['nom']]))	
		{
			$_POST[$donnees['nom']]=1;			
		}
		else
		{
			$_POST[$donnees['nom']]=0;
		}
	}
//re-transmissions des données obtenues dans les pages 1 et 2.
	echo	'<input type="hidden" name="nom-nouv-compte" value="'.$_POST['nom-nouv-compte'].'">
			<input type="hidden" name="password" value="'.$_POST['password'].'">
			<input type="hidden" name="usert" value="'.$_POST['usert'].'">';
	$reque=$bdd->query('SELECT nom FROM groupes_nom WHERE idcompte=2');
	while($donnees=$reque->fetch())
	{
		echo 	'<input type="hidden" name="'.$donnees['nom'].'" value="'.$_POST[$donnees['nom']].'">';	
	}
// contenue du formulaire page 3 
	echo	'<p>Liste des groupes appareils controlable par l\'utilisateur</p>';
	$req=$bdd->query('SELECT nom FROM appareils');
	$inc=0;
	while( $donnees=$req->fetch())
	{
	$inc++;
		echo '<label>'.$donnees['nom'].'</label>
		<div class="checkbox-acces-app">
		<input type="checkbox" name="'.$inc.'" class="checkbox-checkbox" id="'.$inc.'">
		<label class="checkbox-label" for="'.$inc.'">
			<div class="checkbox-inner"></div>
			<div class="checkbox-switch"></div>
		</label>
		</div>';
	} ?>
	<input type="submit" value="Valider">				
	</form> <?php 
}
if($_GET['page']=='newcompte' AND $_SESSION['usert']=='admin' AND isset($_GET['p']) AND $_GET['p']==4)
{ ?>
	<p class="session-title"> Compte cree</p>
<!-- création du compte--><?php
	$req=$bdd->prepare('INSERT INTO comptes VALUES (\'\', :nom, :mdp, "user")');
	$req->execute(array('nom'=>$_POST['nom-nouv-compte'],'mdp'=>$_POST['password']));
//recupération de l'id du compte
	$req=$bdd->query('SELECT id FROM comptes WHERE nom="'.$_POST['nom-nouv-compte'].'"');
	while ($donnees=$req->fetch())
	{
		$idnouvcompte=$donnees['id'];
	}
//attribution de l'accès aux groupes standard
	$req=$bdd->query('SELECT id, nom FROM groupes_nom WHERE idcompte="2"');
	while ($donnees=$req->fetch())
	{
		$requ=$bdd->prepare('INSERT INTO acces_groupes_standard VALUES (\'\', :idgroupe, :idcompte, :acces, :visible)');
		$requ->execute(array('idgroupe'=>$donnees['id'],
							'idcompte'=>$idnouvcompte,
							'acces'=>$_POST[$donnees['nom']],
							'visible'=>$_POST[$donnees['nom']]));
	}
//attribution de l'accès aux appareils
	$req=$bdd->query('SELECT id, nom FROM appareils');
	$inc=0;
	while ($donnees=$req->fetch())
	{
	$inc++;
		if(!empty($_POST[$inc]))
		{
			$acces=1;
		}
		else
		{
			$acces=0;
		}
		$requ=$bdd->prepare('INSERT INTO acces_appareils VALUES (\'\', :idapp, :idcompte, :acces)');
		$requ->execute(array('idapp'=>$donnees['id'],
							 'idcompte'=>$idnouvcompte,
							 'acces'=>$acces));
	}
}
elseif($_GET['page']=='all.editgroupe' AND $_SESSION['usert']=='admin')
{
//si aucun groupe n'est séléctionné allé à "favoris"
// A modidier !
// Aller au groupe au rang 1
	if (!isset($_GET['groupe']))
	{
		$req=$bdd->query('SELECT MIN(id), nom FROM groupes_nom WHERE idcompte=2');
		while ($donnees=$req->fetch())
		{
		$_GET['groupe']=$donnees['nom'];
		}
	}
	echo '<p class="session-title"> Gestion des groupes standards</p></br>';
	if (isset($_GET['groupe']))
	{
		echo' <form method="post" action="change-nom-groupe.php"><p class="nom-gp-chg">
			<label for="oldmdp">Nouveau nom :</label><input type="text" name="new-name" id="new-name"/> 
		 </p>
		 </form>';
	}
	else
	{}?>
	<div id="liste-groupe-reg"><p id="title-liste-groupe">Groupes</p></br><?php
		$req = $bdd->query('SELECT nom, id FROM groupes_nom WHERE idcompte="2"');
		while ($donnees = $req->fetch())
		{ 
		echo '<p class="liste-groupe-reg-nom-select"><a href="reglage-admin.php?page=all.editgroupe&amp;groupe='.$donnees['nom'].'">'.$donnees['nom'].'</a><a href="del-groupe.php?groupe='.$donnees['id'].'&amp;type=standard"><img class="add-delet" src="images/img-croix.png"></a></p>';
		}?>
	</div>
	<div id="liste_app-reg-groupe">
		<p>Appareils dans le groupe :</p></br> <?php
		$req = $bdd->prepare('SELECT  A.nom, B.id
		FROM appareils A
		INNER JOIN groupes_comp B
			ON A.id = B.idappareil 
		INNER JOIN groupes_nom C
			ON B.idgroupe = C.id
		WHERE C.nom=?');
		$req->execute(array($_GET['groupe'])) or die(print_r($req->errorinfo()));
		while ($donnees = $req->fetch())
		{
			echo $donnees['nom'].'<a href="delet-app-groupe.php?app='.$donnees['id'].'&groupe='.$_GET['groupe'].'&amp;type=stand"><img class="add-delet" src="images/img-moins.png"></a></br>';
		}?>
	</div>
	<div id="list-noapp-reg-groupe">
		<p>Appareil n'etant pas dans le groupe :</p></br><?php
		$req = $bdd->prepare('SELECT nom, id
			FROM appareils 
			WHERE id NOT IN (
			SELECT A.id
			FROM appareils A
			INNER JOIN groupes_comp B
				ON B.idappareil=A.id
			INNER JOIN groupes_nom C
				ON B.idgroupe = C.id
			WHERE C.nom=?)');
		$req->execute(array($_GET['groupe'])) or die(print_r($req->errorinfo()));
		while ($donnees = $req->fetch())
		{
			echo $donnees['nom'].'<a href="add-app-groupe.php?app='.$donnees['id'].'&groupe='.$_GET['groupe'].'&amp;type=stand"><img class="add-delet" src="images/img-plus.png"></a></br>';
		}	?>
	</div>
	</div><?php
}
elseif($_GET['page']=='all.newgroupe' AND $_SESSION['usert']=='admin')
{?>
	<p class="session-title"> Nouveau groupe 1/2</p>
	<form method="post" action="reglage-admin.php?page=all.newgroupe2"><p class="new-group">
		<label for="name">Nom :</label><input type="text" name="nom" id="name"/></br>
		<div class="new-groupe-list-app">
		<p>Liste des appareils</p></br><?php
		$req=$bdd->query('SELECT nom FROM appareils');
		$inc="0";
		while($donnees = $req->fetch())
		{
			$inc++;
			echo '<label>'.$donnees['nom'].'</label>
			<div class="checkbox-new-gs">
		<input type="checkbox" name="'.$inc.'" class="checkbox-checkbox" id="'.$inc.'">
		<label class="checkbox-label" for="'.$inc.'">
			<div class="checkbox-inner"></div>
			<div class="checkbox-switch"></div>
		</label>
		</div>';
		}?>
		</div>	
		<input type="submit" value="Valider" /></p>	
	</form><?php
}
elseif($_GET['page']=='all.newgroupe2' AND $_SESSION['usert']=='admin')
{
//page 2 formulaire création nouveau groupe standard.
	echo	'<p class="session-title"> Nouveau groupe standard 2/2</p>
	<form method="post" action="newgroup-standard.php" class="ngs2">
	<input type="hidden" name="nom" value="'.$_POST['nom'].'">';
	$inc=1;
	$requ=$bdd->query('SELECT id FROM appareils	');
	while($donnees = $requ->fetch())
	{
		if(isset($_POST[$inc]))
		{
		echo '<input type="hidden" name="'.$inc.'" value="1">';
		}
		else
		{
		echo '<input type="hidden" name="'.$inc.'" value="0">';	
		}
		$inc++;
	}
	$nb=1;
	$req = $bdd->query('SELECT nom FROM comptes WHERE usert="user"');
	while ($donnees=$req->fetch())
	{
		$usernb='user'.$nb;
		echo    '<label>'.$donnees['nom'].'
		<div class="checkbox-new-gs">
		<input type="checkbox" name="'.$usernb.'" class="checkbox-checkbox" id="'.$usernb.'">
		<label class="checkbox-label" for="'.$usernb.'">
			<div class="checkbox-inner"></div>
			<div class="checkbox-switch"></div>
		</label>
		</div>';
		$nb++;
	}
	echo '<input class="submit" type="submit" value="Valider">
	</form>';
	
}
elseif($_GET['page']=='newdevice' AND $_SESSION['usert']=='admin')
{?>
	<p class="session-title">nouvel appareil</p>
	<form method="post" action="new-app.php" class="new-app">	
		<label for="nom">Nom de l'appareil</label><input type="text" name="nom-nouv-app" id="name"/></br></br>
		<p>Liste des utilisateurs pouvant controler l'appareils <img src="images/aide.png" title="Les administrateurs pourront automatiquement controler l'appareil."></p></br> 	<?php 
		$req=$bdd->query('SELECT nom FROM comptes WHERE usert="user"');
		$increase='0';
		while ($donnees= $req->fetch())
		{
		$increase++;
		echo '<label>'.$donnees['nom'].'</label>
		<div class="checkbox-new-app">
		<input type="checkbox" name="'.$increase.'" class="checkbox-checkbox" id="'.$increase.'">
		<label class="checkbox-label" for="'.$increase.'">
			<div class="checkbox-inner"></div>
			<div class="checkbox-switch"></div>
		</label>
		</div></br>';
		} ?>
		<input type="submit" value="Valider" />
	</form><?php
}?>
		</div>
	</div>
</div>
</body>
</html>