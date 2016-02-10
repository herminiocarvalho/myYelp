<?php
// Require connexion DB
require 'config.php';

// --- Je check le user en session ---
$sessionOk = false;
// Si j'ai les données en session
if (!empty($_SESSION['sess_login']) && !empty($_SESSION['sess_password'])) {
	// J'utilise ma fonction qui vérifie un login/password
	if (checkUser($_SESSION['sess_login'], $_SESSION['sess_password'], true)) {
		$sessionOk = true;

		// Je vérifie que le user est un admin
		// car la page est réservé aux users dont le role est "admin"
		if (isset($_SESSION['sess_role']) && $_SESSION['sess_role'] == 'admin') {
			echo 'you are an admin !!!<br />';
			echo '<a href="signin.php?deconnexion=1">Log off</a>';
		}
		else {
			header('HTTP/1.1 403 Forbidden');
			exit;
		}
	}
	else {
		echo 'login/password are not valid<br />';
	}
}
else {
	echo 'login/password epty<br />';
}

?>