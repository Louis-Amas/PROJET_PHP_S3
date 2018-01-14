<?php
/**
 * Created by PhpStorm.
 * User: remibrizon
 * Date: 14/01/2018
 * Time: 18:18
 */


 session_start();

if (!isset($_POST['submit']))
{
	// formulaire pour s'inscrire car le user n'est pas encore crée
	echo '
	<form id="connect" method="post" action="">
	<fieldset><legend>Formulaire de connexion</legend>
		<p><label for="login">Login : </label><input type="text" id="login" name="login" tabindex="1" value="" /></p>
		<p><label for="pwd">Mot de passe :</label><input type="password" id="pwd" name="pwd" tabindex="2" /></p>
	</fieldset>
	<div><input type="submit" name="submit" value="Connexion" tabindex="3" /></div>
	</form>';
}
else
{

	$login = !empty($_POST['login']) ? $_POST['login'] : NULL;
	$pass = !empty($_POST['password']) ? $_POST['password'] : NULL;
	
	if (($login != '') && ($pwd != ''))
	{
		// Vérifié si le compte existe
		$req_utilisateur = sprintf("SELECT USERNAME, FIRSTNAME, MAIL FROM USER
						WHERE (login = '%s' AND passwd = '%s')",$login, md5($pwd));
		$utilisateur = ($req_utilisateur) or die($req_utilisateur);

		if (($utilisateur) == 1)
		{
			$personne = ($utilisateur);

			// On  enregistre ses données dans la session
			$_SESSION['login'] = $login; //
			$_SESSION['Name'] = $personne['Name'];
			$_SESSION['Username'] = $personne['Username'];
			$_SESSION['TypeDeCompte'] = $personne['TypeDeCompte'];
			$_SESSION['Mail'] = $personne['Mail'];

            echo '<p>Bonjour...... </p>'."\n";
		}
		else
		{
			// Erreur dans le login et / ou dans le mot de passe ...
			echo '<p>Erreur de saisie, veuillez recommencer .... </p>'."\n";
		}
	}

    // Déconnexion
    if ((isset($_GET['act'])) && ($_GET['act'] == 'logout'))
    {
        $_SESSION = array();
        session_destroy();

        // on relance une session pour une éventuelle reconnexion
        session_start();
    };

}
?>
