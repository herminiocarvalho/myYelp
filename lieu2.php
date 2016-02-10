<?php
// Require connexion DB
require 'include/config.php';

// Si un formulaire a été soumis
// Attention, si plusieurs formulaires en POST sur la même page, il va falloir les distinguer
if (!empty($_POST)) {
	//print_pre($_POST);
	// Récupération et traitement des variables du formulaire d'ajout/
        $nom_lieu= isset($_POST['nom_lieu']) ? intval(trim($_POST['nom_lieu'])) : 0;
        $adresse_lieu = isset($_POST['adresse_lieu']) ? intval(trim($_POST['adresse_lieu'])) : 0;
        $description_lieu = isset($_POST['description_lieu']) ? intval(trim($_POST['description_lieu'])) : 0;
        $id_ville=isset($_POST['ville_id_ville']) ? intval(trim($_POST['ville_id_ville'])) : 0;
        $id_codePostale=isset($_POST['codePostale_id_codePostale']) ? intval(trim($_POST['codePostale_id_codePostale'])) : 0;
        $id_categorie=isset($_POST['categorie_id_categorie']) ? intval(trim($_POST['categorie_id_categorie'])) : 0;
	$long_lieu = isset($_POST['long_lieu']) ? intval(trim($_POST['long_lieu'])) : 0;
        $lati_lieu = isset($_POST['lati_lieu']) ? intval(trim($_POST['lati_lieu'])) : 0;
        
         
                // Je fais les vérifications
                $formOk = true;
                /****
               
                 TODDO                 
                 */
                if($formOk)
                // J'écris ma requête dans une variable

                 $sql = 'INSERT
                                INTO
                                  `lieu`(
                                     `nom_lieu`,
                                    `adresse_lieu`,
                                    `ville_id_ville`,
                                    `description_lieu`,
                                    `codePostale_id_codePostale`,
                                    `categorie_id_categorie`,
                                    `lati_lieu`,
                                    `long_lieu`
                                  )
                                VALUES(:nom, :adresse, :id_ville, : description, : id_codePostale,:id_categorie,  :lati, :long)';
                
                // On appelle la fonction qui recupere les latitude et longitude 
                  $pdoStatement = $pdo->prepare($sql);
                        $pdoStatement->bindValue(':nom',$nom_lieu , PDO::PARAM_STR);
                        $pdoStatement->bindValue(':adresse',  $adresse_lieu , PDO::PARAM_STR);
                        $pdoStatement->bindValue(':id_ville',  $id_ville, PDO::PARAM_STR);
                        $pdoStatement->bindValue(':description', $description_lieu , PDO::PARAM_STR);
                        $pdoStatement->bindValue(':description', $id_codePostale , PDO::PARAM_STR);
                        $pdoStatement->bindValue(':id_codePostale', $description_lieu , PDO::PARAM_STR);
                        $pdoStatement->bindValue(':id_categorie', $id_categorie , PDO::PARAM_STR);
                        $pdoStatement->bindValue(':description', $description_lieu , PDO::PARAM_STR);
                
}
