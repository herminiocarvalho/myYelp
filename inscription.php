<?php
// Require connexion DB
require 'include/config.php';
?>
<html>
    <head>
        <title>User sign up</title>
    </head>
    <body>
        <pre><?php
// si formulaire soumis
            if (!empty($_POST)) {
                print_r($_POST);

                // Je récupère les données du post
                $email = isset($_POST['emailToto']) ? trim($_POST['emailToto']) : '';
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
                if (empty($email)) {
                    echo 'email empty<br />';
                    $formOk = false;
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo 'email not valid<br />';
                    $formOk = false;
                }
                if (strlen($passwordToto1) < 8) {
                    echo 'password too short<br />';
                    $formOk = false;
                }

                // Si vérifs ok
                if ($formOk) {
                    // Je teste si l'email existe déjà
                    $checkEmail = '
			SELECT  email_user
			FROM users
			WHERE email_user = :quelquechose
		';
                    $pdoStatement = $pdo->prepare($checkEmail);
                    $pdoStatement->bindValue(':quelquechose', $email, PDO::PARAM_STR);
                    if ($pdoStatement->execute() && $pdoStatement->rowCount() > 0) {
                        echo $email . ' already exists<br />';
                        header('Location: connexion.php');
                         exit();
                    } else {
                        // J'insère en DB


                        $insertUser = '
				INSERT INTO users (email_user, password_user, role_user )
				VALUES (:email, :password,:role )';

                        // Je bind mes variables de requête
                        $pdoStatement = $pdo->prepare($insertUser);
                        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
                        //$pdoStatement->bindValue(':password', md5($passwordToto1.'14!5Toto'), PDO::PARAM_STR);
                        // Je mets le password hashed dans une variable pour pouvoir la mettre en session
                        $passwordHashed = password_hash($passwordToto1, PASSWORD_BCRYPT);
                        $pdoStatement->bindValue(':password', $passwordHashed, PDO::PARAM_STR);
                        // on inscrit que des simple users 
                        $role = "simple";
                        $pdoStatement->bindValue(':role', $role, PDO::PARAM_STR);

                        // J'exécute
                        if ($pdoStatement->execute()) {
                            echo 'user signed up<br />';

                            // On mets les variables en session
                            $_SESSION['sess_login'] = $email;
                            $_SESSION['sess_password'] = $passwordHashed;
                            $_SESSION['sess_role'] = $role;
                            
                            header('Location: accueil.php');
                            exit();
                        } else {
                            echo 'ouch<br />';
                        }
                    }
                }
            }
            ?></pre>

        <form action="" method="post">
            <fieldset>
                <legend>User sign up</legend>
                <input type="email" name="emailToto" value="" placeholder="Email address" /><br />
                <input type="password" name="passwordToto1" value="" placeholder="Your password" /> (8 caractères minimum)<br />
                <input type="password" name="passwordToto2" value="" placeholder="Confirm your password" /><br />
                <input type="submit" value="Sign up">
            </fieldset>
        </form>


    </body>
</html>