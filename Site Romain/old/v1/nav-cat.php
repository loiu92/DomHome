<div class='nav-cat'>
<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=domhome', 'root','');
}
catch(exeption $e)
{
	die('erreur : '. $e->getMessage());
}

$req = $bdd->query('Select nom from categories');
while ($donnees = $req->fetch())
{
?>
<div class='categorie'>
<p><?php echo $donnees['nom']; ?></p>
</div>
<?php
}
$req->closeCursor();
?>
</div>
