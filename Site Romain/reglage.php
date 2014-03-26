<head>
  <meta charset="iso-8859-15">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>DomHome</title>
  <link rel="stylesheet" href="style-accueil.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<!--header + session start-->
<html>
<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

include ('header.php');

// si aucune sous page n'est séléctionnée par l'utilisateur allé à la page "général" 
if (!isset($_GET['page']))
{ 
	$_GET['page']='general';
}?>
<body>
<div class='body'>
	<div id="body-contenu">
		<div id='nav-reglage-fond'>
			<div id='nav-reglage'>
				<p class='session-title'>Les groupes</p>
				<p class='reglages'><a href='reglage.php?page=general'>General</a></br></p>
				<p class='reglages'><a href='reglage.php?page=new-groupe'>Creer un groupe</a> </br></p>
				<p class='reglages'><a href='reglage.php?page=gestion-groupe'>Modifier un groupe</a> </br></p>
				<p class="reglages"><a href="reglage.php?page=groupes-standards">Gestion des groupes standards</a></br></p> 
				<p class='reglages'><a href='reglage.php?page=newprog'>Programmer un appareil</a></br></p>
				<p class='reglages'><a href='reglage.php?page=editprog'>Modifier un programme</a></br></p>
			</div>
		</div>
		<div id='reglage-body'><?php
if ($_GET['page']=='general')
{
	echo'<p class="session-title">Modifier le mot de passe</p>
		<form method="post" action="editmdp.php"><p class="mdpchange">
		<label for="oldmdp">Ancien mot de passe :</label><input type="password" name="old-mdp" id="oldmdp" autocomplete="off"> </br>
		<label for="newmdp1">Nouveau mot de passe :</label><input type="password" name="new-mdp-1" id="newmdp1" autocomplete="off"> </br>
        <label for="oldmdp2">Comfirmer le nouveau mot de passe :</label><input type="password" name="new-mdp-2" id="newmdp2" autocomplete="off"></br> 
		<input type="submit" value="Valider" />	 
		</p>
		</form>';
}
elseif ($_GET['page']=="groupes-standards")
{
	echo'<p class="session-title"> Gestion des groupes standards</p></br>
	     <form method="post" action="gestion-groupes-standard.php"> 
			<div class="groupes-standard-vis">';
				$req=$bdd->prepare('SELECT id FROM comptes WHERE nom=:nom');
				$req->execute(array('nom'=>$_SESSION['nom']));
				while ($donnees=$req->fetch())
				{
					$idcompte=$donnees['id'];
				}
				$inc=0;
				$req=$bdd->prepare('SELECT nom, B.Visible FROM groupes_nom A
									INNER JOIN acces_groupes_standard B
										ON A.id=B.idgroupe
									WHERE B.idcompte= :idcompte
									AND acces="1"');
				$req->execute(array('idcompte'=>$idcompte));
				while ($donnees=$req->fetch())
				{
					if ($donnees['Visible']==1)
					{
						$etat="checked";
					}
					else
					{
						$etat=0;
					}
					echo '<label>'.$donnees['nom'].'</label></br>
							<div class="checkbox">
								<input type="checkbox" name='.$inc.' class="checkbox-checkbox" id='.$inc.' '.$etat.'>
								<label class="checkbox-label" for='.$inc.'>
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div>';
					$inc++;
				}
				 
		echo '<input class="submit" type="submit" value="Valider">
			</div>
		</form>';
}
elseif ($_GET['page']=="gestion-groupe")
{
	// Aller au groupe de rang 1
	if (!isset($_GET['groupe']))
	{
		$req = $bdd->prepare('SELECT id FROM comptes WHERE nom= :nom');
		$req->execute(array('nom' => $_SESSION['nom']));
		While($donnees =$req->fetch())
		{
		$idsession=$donnees['id'];
		}
		$requ=$bdd->prepare('SELECT nom FROM groupes_nom gn
					INNER JOIN order_groupes og
						ON gn.id=og.idgroupe
					WHERE og.rang=1
					AND og.idcompte=:idcompte');
		$requ->execute(array('idcompte'=>$idsession));
		while ($donnees=$requ->fetch())
		{
			$_GET['groupe']=$donnees['nom'];
		}
	}
	echo '<p class="session-title"> Gestion des groupes</p></br>';
	if (isset($_GET['groupe']))
	{
		echo '<form method="post" action="change-nom-groupe.php">
			 <p class="nom-gp-chg">
			 <label for="oldmdp">Modifier le nom du groupe selectione ('.$_GET['groupe'].') :</label><input type="text" name="nouveau-nom" id="new-name"/>
			 <input type="hidden" name="groupe" value="'.$_GET['groupe'].'">
			 <input id="submit" type="submit" value="Valider" />
			 </p>
			 </form>';
	}?>
	<div id="liste-groupe-reg">
		<p id="title-liste-groupe">Groupes</p></br>
		<?php
		$req = $bdd->prepare('SELECT id AS idc FROM comptes WHERE nom= :nom');
		$req->execute(array('nom' => $_SESSION['nom']));
		While($donnees =$req->fetch())
		{
		$idsession = $donnees['idc'];
		}
		$req = $bdd->prepare('SELECT A.nom, A.id FROM groupes_nom A
							INNER JOIN order_groupes C
								ON C.idgroupe=A.id	
							WHERE A.idcompte= :id
							ORDER BY rang');
		$req->execute(array('id' => $idsession));
		while ($donnees = $req->fetch())
		{
			echo '<p class="liste-groupe-reg-nom-select"><a href="reglage.php?page=gestion-groupe&amp;groupe='.$donnees['nom'].'">'.$donnees['nom'].'</a><a href="del-groupe.php?groupe='.$donnees['id'].'&amp;type=groupe"><img class="add-delet" src="images/img-croix.png"></a></p>';
		}?>
	</div>
	<div id="liste_app-reg-groupe">
		<p>Appareils dans le groupe :</p></br>
		<?php
		$req = $bdd->prepare('SELECT  A.nom, C.id FROM appareils A
							INNER JOIN acces_appareils B 
								ON B.idappareil = A.id
							INNER JOIN groupes_comp C
								ON B.id = C.idappareil 
							INNER JOIN groupes_nom D
								ON C.idgroupe = D.id
							WHERE D.nom= :nom
							AND D.idcompte= :idsession
							AND B.acces=1');
		$req->execute(array(
					'nom'=>$_GET['groupe'], 
					'idsession'=>$idsession)) or die(print_r($req->errorinfo()));
		while ($donnees = $req->fetch())
		{
			echo $donnees['nom'].'<a href="delet-app-groupe.php?app='.$donnees['id'].'&groupe='.$_GET['groupe'].'"><img class="add-delet" src="images/img-moins.png"></a></br>';
		}?>
	</div>
	<div id="list-noapp-reg-groupe">
		<p>Appareil n'etant pas dans le groupe :</p></br>
		<?php
		$req = $bdd->prepare('SELECT DISTINCT A.nom, B.id AS BID FROM appareils A	
							INNER JOIN acces_appareils B 
								ON B.idappareil = A.id								
							WHERE A.id NOT IN ( SELECT  A.id FROM appareils A
												INNER JOIN acces_appareils B 
													ON B.idappareil = A.id
												INNER JOIN groupes_comp C
													ON B.id = C.idappareil 
												INNER JOIN groupes_nom D
													ON C.idgroupe = D.id
												WHERE D.nom= :nom
												AND D.idcompte= :idsession
												AND B.acces=1)
							AND B.idcompte= :idsession
							');								
		$req->execute(array(
						'nom'=>$_GET['groupe'], 
						'idsession'=>$idsession)) or die(print_r($req->errorinfo()));
		while ($donnees = $req->fetch())
		{
			echo $donnees['nom'].'<a href="add-app-groupe.php?app='.$donnees['BID'].'&groupe='.$_GET['groupe'].'"><img class="add-delet" src="images/img-plus.png"></a></br>';
		}?>
	</div>
	<?php
}
elseif ($_GET['page']=='new-groupe')
{?>
	<p class="session-title"> Nouveau groupe</p>
	<form method="post" action="newgroup.php">	
		<p class="new-group">
			<label for="name">Nom :</label><input type="text" name="nom" id="name"/></br>
			<div class="new-groupe-list-app">
				<p>Liste des appareils</p></br><?php
				$req=$bdd->prepare('SELECT a.nom FROM appareils a
									LEFT JOIN acces_appareils	pa
										ON a.id = pa.idappareil
									RIGHT JOIN comptes c
										ON c.id = pa.idcompte
									WHERE c.nom=?
									AND pa.acces=1');
				$req->execute(array($_SESSION['nom']));
				$inc="1";
				while($donnees = $req->fetch())
				{
					$inc++;
					echo '<label>'.$donnees['nom'].'</label>
					<div class="checkbox">
						<input type="checkbox" name='.$inc.' class="checkbox-checkbox" id='.$inc.'>
						<label class="checkbox-label" for='.$inc.'>
							<div class="checkbox-inner"></div>
							<div class="checkbox-switch"></div>
						</label>
					</div>'; 
				}?>
			</div>	
		<input type="submit" value="Valider" />
		</p>
	</form>	
	<?php 
}
elseif($_GET['page']=='newprog')
{ ?>
	<div class="newprog-fond">
		<p class="session-title-prog">Nouveau programme</p>
		<form method="post" action="reglage.php?page=newprog">
			<p class="newprog">
				<label>Appareil :</label>
				<SELECT id="app-select">
					<option selected="selected"></option>
					<?php 
					$req = $bdd->prepare('SELECT a.id, c.nom FROM comptes a
										LEFT JOIN acces_appareils b 
											ON a.id = b.idcompte
										INNER JOIN appareils c
											ON b.idappareil = c.id
										WHERE a.nom=?
										WHERE b.acces=1');
					$req->execute(array($_SESSION['nom']));
					while( $donnees = $req->fetch())
					{
						echo '<option>'.$donnees['nom'].'</option>';
					}?>
				</SELECT></br>
				<label for="">Type d'evenement :</label>
				<?php
				if (isset($_POST['typevent']) AND $_POST['typevent']=="unique")
				{ 
					echo '
						<SELECT onChange="this.form.submit()" name="typevent">
							<option selected="selected">unique</option>
							<option>recurrent</option>
						</SELECT></br>
						<label for="">Date (A:M:J) :</label><input type="date" name="heure" value="0000:00:00" id="date"/> </br>
						<label for="">Heure (h:mm) :</label><input type="time" name="heure" value="00:00" id="heure"/> </br>
						<label>Effet :</label>
						<SELECT> 
							<option>Allumer</option>
							<option>Eteindre</option>
						</SELECT></br>
						<input type="submit" value="Valider" />';
				}
				elseif (isset($_POST['typevent']) AND $_POST['typevent']=="recurrent")
				{
					echo'
						<SELECT onChange="this.form.submit()" name="typevent">
							<option>unique</option>
							<option selected="selected">recurrent</option>
						</SELECT></br>
						<label for="" class="label">Heure (h:mm) :</label><input type="time" name="heure" value="00:00" id="heure"/>	</br>
						<label> Lundi</label>
							<div class="checkbox-prog">
								<input type="checkbox" name="lundi" class="checkbox-checkbox" id="lundi">
								<label class="checkbox-label" for="lundi">
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div></br>
						<label class="label"> Mardi</label>
							<div class="checkbox-prog">
								<input type="checkbox" name="mardi" class="checkbox-checkbox" id="mardi">
								<label class="checkbox-label" for="mardi">
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div></br>
						<label class="label"> Mercredi</label>
							<div class="checkbox-prog">
								<input type="checkbox" name="mercredi" class="checkbox-checkbox" id="mercredi">
								<label class="checkbox-label" for="mercredi">
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div></br>
						<label class="label"> jeudi</label>
							<div class="checkbox-prog">
								<input type="checkbox" name="jeudi" class="checkbox-checkbox" id="jeudi">
								<label class="checkbox-label" for="jeudi">
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div></br>
						<label class="label"> Vendredi</label>
							<div class="checkbox-prog">
								<input type="checkbox" name="vendredi" class="checkbox-checkbox" id="vendredi">
								<label class="checkbox-label" for="vendredi">
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div></br>
						<label class="label"> Samedi</label>
							<div class="checkbox-prog">
								<input type="checkbox" name="samedi" class="checkbox-checkbox" id="samedi">
								<label class="checkbox-label" for="samedi">
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div></br>
						<label class="label"> Dimanche</label>
							<div class="checkbox-prog">
								<input type="checkbox" name="dimanche" class="checkbox-checkbox" id="dimanche">
								<label class="checkbox-label" for="dimanche">
									<div class="checkbox-inner"></div>
									<div class="checkbox-switch"></div>
								</label>
							</div></br>
						<label>Effet :</label>
						<SELECT> 
							<option>Allumer</option>
							<option>Eteindre</option>
						</SELECT></br>
						<input type="submit" value="Valider" />';
				}
				else
				{
					echo'<SELECT onChange="this.form.submit()" name="typevent">
							<option selected="selected"></option>
							<option>unique</option>
							<option>recurrent</option>
						</SELECT></br>';
				} ?>
			</p>
		</form>
	</div>
	<div class="newprog-fond1">
		<p class="session-title-prog">Nouveau timer</p>
		<form method="post" action="reglage.php?page=newprog"><p class="newprog">
			<label>Appareil :</label>
			<SELECT id="app-select-timer">
				<option selected="selected"></option>
				<?php 
				$req = $bdd->prepare('SELECT a.id, c.nom FROM comptes a
									LEFT JOIN acces_appareils b 
										ON a.id = b.idcompte
									INNER JOIN appareils c
										ON b.idappareil = c.id
									WHERE a.nom=?
									WHERE b.acces=1');
				$req->execute(array($_SESSION['nom']));
				while( $donnees = $req->fetch())
				{
					echo '<option>'.$donnees['nom'].'</option>';
				}?>
			</SELECT></br>
		</form>
	</div><?php
}
elseif($_GET['page']=='editprog')
{
	echo 'editer un programme';
}?>
		</div>
	</div>
</div>
</body>
</html>