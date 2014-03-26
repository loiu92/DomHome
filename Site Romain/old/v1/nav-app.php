<div class='nav-app'>
<div class='nom-cat'>
<h1>Lampes</h1>
</div>

<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=domhome', 'root','');
}
catch(exeption $e)
{
	die('erreur : '. $e->getMessage());
}

$req = $bdd->query('Select appareil, etat from Lampes');

while ($donnees = $req->fetch())
{
?>
<div class='appareil'>
<?php
echo $donnees['appareil'];
?>
</div>
<?php
}
$req->closeCursor();
?>
</div>