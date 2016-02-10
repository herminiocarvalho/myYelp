<?php
// Require connexion DB
require 'include/config.php';
?><html>
<head>
	<title>Password forgotten</title>
</head>
<body>
<?php

// Si formulaire soumis
if (!empty($_POST)) {
	// Je récupère la donnée en POST
	$email = isset($_POST['emailLostPassword']) ? trim($_POST['emailLostPassword']) : '';

	// Je check la validité des données
	if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
		$checkEmail = '
			SELECT id_user, password_user
			FROM users
			WHERE email_user = :email
		';
		$pdoStatement = $pdo->prepare($checkEmail);
		$pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
		// J'exécute ma requete et je teste si j'ai des résultats
		if ($pdoStatement->execute() && $pdoStatement->rowCount() > 0) {
			// => L'email existe
			$res = $pdoStatement->fetch();
			// Je créé un token à partir des informations du user
			$token = md5($email.'sdfghr45f'.$res['password_user']);

			$emailHTML = '<html>
			<head><title>Lost password</title></head>
			<body>
			Dear user,<br />
			<br />
			You\'ve asked to change your password.<br />
			<a href="'.ABSOLUTE_URL.'change_password.php?email='.$email.'&token='.$token.'">Click here to change your password</a>.<br />
			<br />
			Best regards,
			Toto
			</body>
			</html>';
			$emailText = 'Go here : '.ABSOLUTE_URL.'change_password.php?email='.$email.'&token='.$token;
			$subject = 'Lost password on Our Website';
			// On envoie l'email
			if (autoMail($email, $subject, $emailHTML, $emailText)) {
				echo 'An email has been sent to '.$email.'<br />';
			}
			else {
				echo 'arf, email could not be sent<br />';
			}
		}
		else {
			// L'email n'existe pas
			echo 'Sorry, this email does not exists<br />';
		}
	}
	else {
		echo 'email is not valid<br />';
	}
}

?>
	<form action="" method="post">
		<fieldset>
			<legend>Lost password</legend>
			<input type="email" name="emailLostPassword" value="" placeholder="Email address" /><br />
			<input type="submit" value="Change password"><br />
		</fieldset>
	</form>

</body>
</html>