<?php

session_start();

// Connexion à la DB
$dsn = 'mysql:dbname=myyelp;host=localhost;charset=UTF8';
$user = 'root';
$passwordDb = '';
// Effectuer la connexion
$pdo = new PDO($dsn, $user, $passwordDb);
echo 'connectionn ok';

// Un define, une constante
define('ABSOLUTE_URL', 'http://localhost/myYelp/');

function checkUser($userEmail, $userPassword, $alreadyHashed = false) {
    global $pdo;
    // Je prépare ma requête
    $checkUser = '
                  SELECT
                  `id_user`,
                  `email_user`,
                  `password_user`,
                  `role_user`
                FROM
                  `users`
               
		WHERE email_user = :user
	';
    $pdoStatement = $pdo->prepare($checkUser);
    $pdoStatement->bindValue(':user', $userEmail, PDO::PARAM_STR);

    // J'exécute
    if ($pdoStatement->execute()) {
        if ($pdoStatement->rowCount() > 0) {
            // Je récupère le mot de passe
            $res = $pdoStatement->fetch();
            $passwordHashed = $res['password_user'];
            $userRole = $res['role_user'];

            // Si le mot de passe fourni est déjà haché
            if ($alreadyHashed) {
                if ($userPassword == $passwordHashed) {
                    return true;
                }
            }
            // Je check le mot de passe haché
            else {
                if (password_verify($userPassword, $passwordHashed)) {
                    // On mets les variables en session
                    $_SESSION['sess_login'] = $userEmail;
                    $_SESSION['sess_password'] = $passwordHashed;
                    $_SESSION['sess_role'] = $userRole;

                    return true;
                }
            }
        }
    }
    return false;
}

function autoMail($to, $subject, $messsageHTML, $messageText) {
    require_once 'PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.googlemail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'myyelpmyyelp@gmail.com';                 // SMTP username
    $mail->Password = '@E123456789@E';  // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('myyelpmyyelp@gmail.com', 'ben wf3');
    $mail->addAddress($to);
    //$mail->addBCC('webmaster@monsite.lu');

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $messsageHTML;
    $mail->AltBody = $messageText;

    return $mail->send();
}

// function to geocode address, it will return false if unable to geocode address
function geocode($address) {

    // url encode the address
    $address = urlencode($address);

    // google map geocode api url
    $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

    // get the json response
    $resp_json = file_get_contents($url);

    // decode the json
    $resp = json_decode($resp_json, true);

    // response status will be 'OK', if able to geocode given address 
    if ($resp['status'] == 'OK') {

        // get the important data
        $lati = $resp['results'][0]['geometry']['location']['lat'];
        $longi = $resp['results'][0]['geometry']['location']['lng'];


        // verify if data is complete
        if ($lati && $longi) {

            // put the data in the array
            $data_arr = array();

            array_push(
                    $data_arr, $lati, $longi
            );

            return $data_arr;
        }
    }
}
