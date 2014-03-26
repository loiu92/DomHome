<?php 
// session start + connexion BDD + utilisateur à accès à la page ?
include ('acces-page.php');

$req = $bdd->prepare('DELETE FROM groupes_comp WHERE id=?');
$req->execute(array($_GET['app']));
if ($_GET['type'] == "stand")
{
	header('location: reglage-admin.php?page=all.editgroupe&groupe='.$_GET['groupe'].'');
}
else
{
	header('location: reglage.php?page=gestion-groupe&groupe='.$_GET['groupe'].'');
}
?>


