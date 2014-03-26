<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="fr"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="fr"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="fr"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Se connecter</title>
        	<link rel="stylesheet" href="style.css">
    </head>
    <body>
     <?php
    if (isset($_POST['mdp']) AND $_POST['mdp'] == 'admin') // Si le mot de passe est bon
    {
	 header('location: test.php');
	 exit;
	}
    else
{
	        echo '<div class="message error"><div class="icon"></div>You entered in a wrong password <div class="triangle"></div></div>'; 
}
?>
			  <form class="sign-up" action="test.php" method="post">
    <input type="text" class="sign-up-input" placeholder="Adresse mail" autofocus name="nom">
    <input type="password" class="sign-up-input" placeholder="mot de passe" name="mdp">
    <input type="submit" value="Se connecter !" class="sign-up-button">
  </form>;	
    
        
    </body>
</html>