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

            //on recupere tous les users 
            $sql = "SELECT
                    `id_user`,
                    `email_user`,
                    `password_user`,
                    `role_user`
                    FROM
                    `user`
                  ";
            //on prepare la requette
            $pdoStatement = $pdo->prepare($sql);
          
            //on execute la query
            $pdoStatement->execute();

            if ($pdoStatement->rowCount() > 0) {
                $result = $pdoStatement->fetchAll();
                print_r($result);
                foreach ($result as $key => $value) {
                    
           
                ;?>
                    
                   <select>
                       
                       <option value="<?php $value['email_user'];?>"><?php echo $value['email_user'];?></option>
                      
                  </select>                 
                     <?php
                }
            
            }

            ;
            ?>
        </pre>
    </body>
</html>
