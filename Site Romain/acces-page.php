<?php
//début de la session
session_start();

  $dbhost = 'local';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'domhome';

    $bdd = mysql_connect($dbhost, $dbuser, $dbpass)
        or die ('Error connecting to mysql');

    mysql_select_db($dbname)
        or die ('Error selecting database');
    return $conn;

//l'utilisateur à accès à cette page ?
if (!isset($_SESSION['nom']))
{
	header('location: index.php?connexion=false');
}
$req = $bdd->prepare('Select nom, mdp from comptes where nom = ?');
$req->execute(array($_SESSION['nom'])) or die(print_r($req->errorinfo()));
while ($donnees = $req->fetch())
{
	if ($donnees['mdp'] != $_SESSION['mdp'])
	{
		header('location: index.php?connexion=false');
	}
}
