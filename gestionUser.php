<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <pre>
            <?php
            require_once 'include/config.php';

            // Gestion du POST du formulaire
            if (!empty($_POST)) {
                $id_user = isset($_POST['id_user']) ? intval($_POST['id_user']) : 0;
                $email_user = isset($_POST['email_user']) ? trim($_POST['email_user']) : '';
                $role_user = isset($_POST['role_user']) ? trim($_POST['role_user']) : '';
             // si l'id dans le formulaire est > 0 => lieu  existant => modification
                print_r($_POST);
                if ($id_user > 0) {     
                   // J'écris ma requête dans une variable 
                    $sql = 'UPDATE  `users` SET  `role_user` = :role
                        WHERE  id_user= :id_user';
                   
                // Je prépare ma requête
                $pdoStatement = $pdo->prepare($sql);
                // Je bind toutes les variables de requête
            
                $pdoStatement->bindValue(':role', $role_user);
                $pdoStatement->bindValue(':id_user', $id_user);

                //$pdoStatement->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                // J'exécute la requête, et ça me renvoi true ou false
                if ($pdoStatement->execute()) {
                    // Je redirige sur la même page
                    // Pas de formulaire soumis sur la page de redirection => pas de POST
                 
                    header('Location: gestionUser.php?id=' . $id_user);
                    exit;
                }
                else {
                        print_r($pdoStatement->errorInfo());
                    
                    }
               }
            }
            // J'initialise mes variables pour l'affichage du formulaire/de la page
            $currentId = 0;
            $email_user = '';
            $role_user = '';
            $id_user=0;
         

            // Si l'id est passé en paramètre => je pré-remplis le formulaire pour la modification
            if (isset($_GET['id'])) {
                $currentId = intval($_GET['id']);
                //on recupere tous les users 
                $sql = 'SELECT
                     `email_user`,
                     `role_user`
                    FROM
                    `users`
                    WHERE id_user = ' . $currentId;
                // J'envoi ma requête à MySQL et je récupère le Statement
                $pdoStatement = $pdo->query($sql);
                // Si la requête a fonctionnée et qu'on a au moins une ligne de résultat
                if ($pdoStatement && $pdoStatement->rowCount() > 0) {
                    // Je "fetch" les données de la première ligne de résultat dans $resList
                    $resList = $pdoStatement->fetch();
                    print_r($resList);
                    // Je récupère toutes les valeurs que j'affecte dans les variables destinées à l'affichage du formulaire
                    // => ça me permet de pré-remplir le formulaire
                    $email_user =$resList['email_user'];
                    $role_user= $resList['role_user'];
                }
            }
            // Récupère toutes les users  pour générer le menu déroulant des users
            $sql = 'SELECT `id_user`, `email_user`,`role_user` FROM `users` ';

            $pdoStatement = $pdo->query($sql);
            if ($pdoStatement && $pdoStatement->rowCount() > 0) {
                $usersList = $pdoStatement->fetchAll();
            }
            
            
 ;?>                    
        </pre>  

    <legend>Enregistrer Lieu</legend>
    <form action="" method="post">
        <fieldset>
             <input type="hidden" name="id_user" value="<?php echo $currentId; ?>" />
            
            <table>
                <tr>
                    <td>Users :&nbsp;</td>
                    <td><select  name="id_user_select">
                            <option value="">choisissez</option>
                            <?php foreach ($usersList as $curUser) : ?>
                                <!--On va recuperer cet id_user pour modifier le user -->
                               <option value="<?php echo $curUser['id_user']; ?>"<?php echo $id_user== $curUser['id_user'] ? ' selected="selected"' : ''; ?>><?php echo $curUser['email_user']; ?></option>
                               
                            <?php endforeach; ?>
                        </select></td>

                </tr>
                
                <tr>
                    <td>role :&nbsp;</td>
                    <td><input type="text" name="role_user" value="<?php echo $role_user; ?>"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="<?php
                        if ($currentId > 0) {
                            echo 'Modifier';
                        } else {
                            echo 'Choissier un user ou quitter';
                        }
                        ?>"/></td>
                </tr>   
            </table>
        </fieldset>
    </form> 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="script/script.js"></script>

</body>
</html>
