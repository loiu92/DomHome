<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="fr"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="fr"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="fr"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Se connecter</title>
  <link rel="stylesheet" href="style.old.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<?php
session_start();
if(isset($_GET['connexion']))
{}
else
{$_GET['connexion']='true';} ?>

<?php
if ($_GET['connexion']=='false')
{
?>
<?php	        echo '<div class="message error"><div class="icon"></div>You entered in a wrong password <div class="triangle"></div></div>'; 
?>
			  <form class="sign-up" action="test.php" method="post">
    <input type="text" class="sign-up-input" placeholder="Adresse mail" autofocus name="nom">
    <input type="password" class="sign-up-input" placeholder="mot de passe" name="mdp">
    <input type="submit" value="Se connecter !" class="sign-up-button">
  </form>;	

<?php
}
else
{
?>
  <form class="sign-up" action="test.php" method="post">
    <input type="text" class="sign-up-input" placeholder="Adresse mail" autofocus name="nom">
    <input type="password" class="sign-up-input" placeholder="mot de passe" name="mdp">
    <input type="submit" value="Se connecter !" class="sign-up-button">
  </form>

 
 
  <div class="about">
     <p class="about-author">
      &copy; 2013 <a href="http://thibaut.me" target="_blank">DomoHome </a>
     </p>
  </div>
 <?php
 }
 ?>
</html>
