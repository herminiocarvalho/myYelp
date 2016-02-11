<?php
// Require connexion DB
require 'include/config.php';
?><html>
<head>
	<title>Change Password</title>
</head>
<body>

	<?php


	$emailClient = isset($_GET['email']) ? trim($_GET['email']) : '';
	$token = isset($_GET['token']) ? trim($_GET['token']) : '';

// J'initialise ma variable
	$tokenOk = false;
// Token fourni
	if (!empty($token)) {
	// Devrait etre mis dans une fonction car répété !!!!!!!
		$checkEmail = '
		SELECT id_user,password_user
		FROM users
		WHERE email_user = :email
		';
		$pdoStatement = $pdo->prepare($checkEmail);
		$pdoStatement->bindValue(':email', $emailClient, PDO::PARAM_STR);
	// J'exécute ma requete et je teste si j'ai des résultats
		if ($pdoStatement->execute() && $pdoStatement->rowCount() > 0) {
		// => L'email existe
			$res = $pdoStatement->fetch();
		// Je créé le token à partir des informations du user
			$tokenValid = md5($emailClient.'sdfghr45f'.$res['password_user']);
			$currentId = $res['id_user'];

		// Je teste le bon token généré avec le token fourni
			if ($tokenValid === $token) {
				$tokenOk = true;


			}
			else {
				echo 'token invalid<br />';
			}
		}
		else {
			echo 'email does not exists<br />';
		}
	}
	else {
		echo 'token empty<br />';
	}


 // si formulaire soumis


	if (!empty($_POST)) {
		print_r($_POST);

                // Je récupère les données du post
		$id_user = isset($_POST['id_user']) ? intval($_POST['id_user']) : 0;
		$passwordToto1 = isset($_POST['passwordToto1']) ? trim($_POST['passwordToto1']) : '';
		$passwordToto2 = isset($_POST['passwordToto2']) ? trim($_POST['passwordToto2']) : '';

                // Je fais les vérifications
		$formOk = true;
		if (empty($passwordToto1)) {
			echo 'password empty<br />';
			$formOk = false;
		}
		if ($passwordToto1 !== $passwordToto2) {
			echo 'passwords are differents<br />';
			$formOk = false;
		}


		if (strlen($passwordToto1) < 8) {
			echo 'password too short<br />';
			$formOk = false;
		}

        // Si vérifs ok
		if ($formOk) {

            // J'insère en DB
			$changPass = 'UPDATE  `users` 
			SET `password_user` = :password
			WHERE  id_user= :id_user';
            // Je bind mes variables de requête
			$pdoStatement = $pdo->prepare($changPass);

			$pdoStatement->bindValue(':id_user', $id_user);
			$passwordHashed = password_hash($passwordToto1, PASSWORD_BCRYPT);
			$pdoStatement->bindValue(':password', $passwordHashed, PDO::PARAM_STR);

            // J'exécute
			if ($pdoStatement->execute()) {
				echo 'Le password a été changé up<br />';
				header('Location: accueil.php');
				exit();
			} else {
				echo 'Problem connection<br />';
				header('Location: lost_password.php');
				exit();
			}
		}
	}

	?>
	<?php
	if ($tokenOk) {
		?>
		<form action="" method="post">
			<fieldset>
				<legend>Change password</legend>
				<input type="hidden" name="id_user" value="<?php echo $currentId; ?>" />
				<!--	<input type="hidden" name="emailToto" value="<?php echo $emailClient; ?>" />  -->
				<input type="password" name="passwordToto1" value="" placeholder="Your password" /> (8 caractères minimum)<br />
				<input type="password" name="passwordToto2" value="" placeholder="Confirm your password" /><br />
				<input type="submit" value="Change password"><br />
			</fieldset>
		</form>
		<?php
	}
	?>
</body>
</html>

