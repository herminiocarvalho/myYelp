<?php
// Require connexion DB
require 'include/config.php';
?>
<html>
<head>
	<title>User sign in Page connextion</title>
</head>
<body>
<pre><?php

// formulaire soumis
if (!empty($_POST)) {
	print_r($_POST);
	// Je récupère les données en POST
	$emailSignIn = isset($_POST['emailSignIn']) ? trim($_POST['emailSignIn']) : '';
	$passwordSignIn = isset($_POST['passwordSignIn']) ? $_POST['passwordSignIn'] : '';

	// Je fais les vérifications
	if (!empty($emailSignIn) && !empty($passwordSignIn)) {
		// J'utilise ma fonction qui vérifie un login/password
		if (checkUser($emailSignIn, $passwordSignIn)) {
			echo 'sign in ok<br />';
		}
		else {
			echo 'email and/or password are not valid<br />';
		}
	}
	else {
		echo 'email and/or password are empty<br />';
	}
}
?>
</pre>
<?php
// --- Je check le user en session ---
$sessionOk = false;
// Si j'ai les données en session
if (!empty($_SESSION['sess_login']) && !empty($_SESSION['sess_password'])) {
	// J'utilise ma fonction qui vérifie un login/password
	if (checkUser($_SESSION['sess_login'], $_SESSION['sess_password'], true)) {
		// Je déconnecte si demandé
		if (!empty($_GET['deconnexion'])) {
			session_destroy();
			echo 'logged off<br />';
		}
		else {
			$sessionOk = true;
			echo 'you are logged in<br />';
			echo '<a href="signin.php?deconnexion=1">Log off</a>';
                        header('Location: accueil.php');
		}
	}
}
// Sinon, j'affiche le formulaire de connexion
if (!$sessionOk) {
?>
<form action="" method="post">
	<fieldset>
		<legend>User sign in</legend>
		<input type="email" name="emailSignIn" value="" placeholder="Email address" /><br />
		<input type="password" name="passwordSignIn" value="" placeholder="Your password" /><br />
		<input type="submit" value="Sign in"> <a href="lost_password.php">Lost password ?</a><br />
	</fieldset>
</form>
<?php
}
?>

</body>
</html>