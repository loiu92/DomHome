<div class="background">
<?php
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

// changement d'état d'un appareil lorsque l'utilisateur clique sur un interrupteur.
if (isset($_POST['app']) AND ($_POST['etat']==1 OR $_POST['etat']==0) )
{
	$requ=$bdd->prepare('UPDATE appareils SET onoff = :app WHERE id= :id');
	$requ->execute(array(
		'app' => $_POST['etat'],
		'id' => $_POST['app'])) or die(print_r($req->errorinfo()));
}

//affiché 'groupe' par défault.
if(!isset($_GET['groupe']))
{
	$_GET['groupe']='Favoris';
} 
	
//header
include ('header.php');?>

<!--menus-->
<body>
<div class='body'>
	<div id="body-contenu">
		<div id='liste-categories'>
			<?php
			echo '<p class="title-cat">Groupes</p>';
			$req = $bdd->prepare('SELECT id AS idc FROM comptes WHERE nom= :nom');
			$req->execute(array('nom' => $_SESSION['nom']));
			While($donnees =$req->fetch())
			{
				$idsession = $donnees['idc'];
			}
//liste des groupes
			$req = $bdd->prepare('Select nom from groupes_nom A
					LEFT JOIN acces_groupes_standard B 
						ON B.idgroupe=A.id		
					LEFT JOIN order_groupes C
						ON C.idgroupe=A.id		
					WHERE A.idcompte= :idsession
					OR (B.idcompte= :idsession AND B.acces="1" AND B.visible="1") ORDER BY C.rang');	
			$req->execute(array('idsession'=>$idsession));
			while ($donnees = $req->fetch())
			{
	// groupe selectionné
				if ($_GET['groupe']==$donnees['nom'])
				{
					echo '<a href="accueil.php?groupe='.$donnees['nom'].'">
					<div class="categorie-select">
						'.$donnees['nom'].'
					</div></a>';
				}
	// autres groupes
				else
				{
					echo '<a href="accueil.php?groupe='.$donnees['nom'].'">
					<div class="categorie">
						'.$donnees['nom'].'
					</div></a>';
				}
			}?>
		</div>
<!--liste des appareils - états - controles-->
		<div id='appareils-control'>
			<div id='fond-liste-appareils'>
			</div>
			<div id='liste-appareils'>
				<div id='nom-categorie-appareils'>
					<?php echo '<p class="nom-cat-selec">'.$_GET['groupe'].'</p>';?>
				</div>
<!--nom des appareils appartenant au groupe-->
				<?php
				$req = $bdd->prepare('SELECT  A.nom
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
				while ($donnees = $req->fetch())
				{
					echo '<div class="appareils">'.$donnees['nom'].'</div>';
				}?>
			</div>
			<div id='fond-etat-appareils'></div>
			<div id='etat-appareils'>
				<div id='etat'>
					<p>Etat </p>
				</div>
				<div id="contenu-etat">