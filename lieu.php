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
            // Require connexion DB
            require 'include/config.php';

            // Si un formulaire a été soumis
            // Attention, si plusieurs formulaires en POST sur la même page, il va falloir les distinguer
            if (!empty($_POST)) {
                print_r($_POST);
                // Récupération et traitement des variables du formulaire d'ajout/
                $id_lieu = isset($_POST['id_lieu']) ? intval(trim($_POST['id_lieu'])) : 0;
                $nom_lieu = isset($_POST['nom_lieu']) ? trim($_POST['nom_lieu']) : 0;
                $adresse_lieu = isset($_POST['adresse_lieu']) ? trim($_POST['adresse_lieu']) : 0;
                $description_lieu = isset($_POST['description_lieu']) ? trim($_POST['description_lieu']) : 0;
                $id_ville = isset($_POST['ville_id_ville']) ? intval(trim($_POST['ville_id_ville'])) : 0;
                $id_codePostale = isset($_POST['codePostale_id_codePostale']) ? trim($_POST['codePostale_id_codePostale']) : 0;
                $id_categorie = isset($_POST['categorie_id_categorie']) ? intval(trim($_POST['categorie_id_categorie'])) : 0;

                // On appelle la fonction qui donne les latitudes 
                $data = geocode($adresse_lieu);
                print_r($data);
                $lati_lieu = $data[0];
                $long_lieu = $data[1];
                // si l'id dans le formulaire est > 0 => film existant => modification
                if ($id_lieu > 0) {
                    // J'écris ma requête dans une variable
                    $updateSQL = 'UPDATE
                              `lieu`
                            SET
                              `nom_lieu` = :nom,
                              `adresse_lieu` = :adresse,
                              `ville_id_ville` = id_ville,
                              `description_lieu` = :description,
                              `codePostale_id_codePostale` = :id_codePostale,
                              `categorie_id_categorie` = :id_categorie,
                              `lati_lieu` = :lati,
                              `long_lieu` = :longi
                               WHERE   id_lieu= :  id_lieu';
                    // Je prépare ma requête
                    $pdoStatement = $pdo->prepare($updateSQL);
                    // Je bind toutes les variables de requête
                    $pdoStatement->bindValue(':nom', $nom_lieu);
                    $pdoStatement->bindValue(':adresse', $adresse_lieu);
                    $pdoStatement->bindValue(':id_vile', $id_ville);
                    $pdoStatement->bindValue(':description', $description_lieu);
                    $pdoStatement->bindValue(':id_codePostale', $id_codePostale);
                    $pdoStatement->bindValue(':id_categorie', $id_categorie);
                    $pdoStatement->bindValue(':lati_lieu', $lati_lieu);
                    $pdoStatement->bindValue(':long_lieu', $long_lieu);
                   // $pdoStatement->bindValue(':id_lieu', $id_lieu);
                    // J'exécute la requête, et ça me renvoi true ou false
                    if ($pdoStatement->execute()) {
                        // Je redirige sur la même page
                        // Pas de formulaire soumis sur la page de redirection => pas de POST
                        header('Location: lieu.php?id=' . $id_lieu);
                        exit;
                    }
                }
                // sinon on ajoute 
               else  {
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
                                VALUES (:nom, :adresse, :id_ville, :description, :id_codePostale,:id_categorie,  :lati, :long)';
                    echo $sql;
                    // Je prépare ma requête
                    $pdoStatement = $pdo->prepare($sql);
                    $pdoStatement->bindValue(':nom', $nom_lieu, PDO::PARAM_STR);
                    $pdoStatement->bindValue(':adresse', $adresse_lieu, PDO::PARAM_STR);
                    $pdoStatement->bindValue(':id_ville', $id_ville, PDO::PARAM_STR);
                    $pdoStatement->bindValue(':description', $description_lieu, PDO::PARAM_STR);
                    $pdoStatement->bindValue(':id_codePostale', $id_codePostale, PDO::PARAM_STR);
                    $pdoStatement->bindValue(':id_categorie', $id_categorie, PDO::PARAM_STR);
                    $pdoStatement->bindValue(':lati', $lati_lieu, PDO::PARAM_STR);
                    $pdoStatement->bindValue(':long', $long_lieu, PDO::PARAM_STR);

echo "$id_categorie";
                    // J'exécute
                    if ($pdoStatement->execute()) {
                        echo "jhgkhgkh";
                        $newId = $pdo->lastInsertId();
                        // Je redirige sur la même page, à laquelle j'ajoute l'id du lieu créé => modification
                        // Pas de formulaire soumis sur la page de redirection => pas de POST
                        header('Location: lieu.php?id=' . $newId);
                        exit;
                    }
                    else {
                        print_r($pdoStatement->errorInfo());
                    }
                }
            }
// J'initialise mes variables pour l'affichage du formulaire/de la page
$currentId = 0;
$nom_lieu = '';
$adresse_lieu = '';
$id_ville='';
$description_lieu = '';
$id_lieu = 0;
$id_categorie = 0;
$id_codePostale = '';
$lati_lieu = 0;
$long_lieu = 0;
$cp_codePostale='';

            // Si l'id est passé en paramètre de l'URL : "lieu.php?id=54" => $_GET['id'] à pour valeur 54
            if (isset($_GET['id'])) {
                // Je m'assure que la valeur est un integer
                $currentId = intval($_GET['id']);
                // J'écris ma requête dans une variable
                $sql = 'SELECT
                                `nom_lieu`,
                                `adresse_lieu`,
                                `ville_id_ville`,
                                `description_lieu`,
                                `codePostale_id_codePostale`,
                                `categorie_id_categorie`,
                                `lati_lieu`,
                                `long_lieu`
                              FROM
                                `lieu`
                              WHERE  id_lieu = ' . $currentId;
                // J'envoi ma requête à MySQL et je récupère le Statement
                $pdoStatement = $pdo->query($sql);
                // Si la requête a fonctionnée et qu'on a au moins une ligne de résultat
                if ($pdoStatement && $pdoStatement->rowCount() > 0) {
                    // Je "fetch" les données de la première ligne de résultat dans $resList
                    $resList = $pdoStatement->fetch();
                    // Je récupère toutes les valeurs que j'affecte dans les variables destinées à l'affichage du formulaire
                    // => ça me permet de pré-remplir le formulaire
                    $nom_lieu = $resList['nom_lieu'];
                    $adresse_lieu = $resList['adresse_lieu'];
                   // $id_ville = intval($resList['id_ville']);
                    $description_lieu = $resList['description_lieu'];
                   // $id_codePostale = $resList['id_codePostale'];
                   // $id_categorie = intval($resList['id_categorie']);
                    $long_lieu = $resList['long_lieu'];
                    $lati_lieu = $resList['lati_lieu'];
                   
                }
            }

// Récupère toutes les categories  pour générer le menu déroulant des supports
            $sql = 'SELECT  `id_categorie`, `nom_categorie`
                      FROM  `categorie`  ';
                 
            $pdoStatement = $pdo->query($sql);
            if ($pdoStatement && $pdoStatement->rowCount() > 0) {
                $categoriesList = $pdoStatement->fetchAll();
            }
              
// Récupère toutes les villes  pour générer le menu déroulant des supports
            $sql = 'SELECT  `id_ville`, `nom_ville`
                      FROM  `ville`  ';
                 
            $pdoStatement = $pdo->query($sql);
            if ($pdoStatement && $pdoStatement->rowCount() > 0) {
                $villesList = $pdoStatement->fetchAll();
              
            }
  // Récupère tous les code postaux pour générer le menu déroulant des supports
            $sql = 'SELECT  `id_codePostale`, `cp_codePostale`
                      FROM  `codepostale`  ';
                 
            $pdoStatement = $pdo->query($sql);
            if ($pdoStatement && $pdoStatement->rowCount() > 0) {
                $codePostauxList = $pdoStatement->fetchAll();
               
            }
            ?>
        </pre>
        <form action="" method="post">
            <fieldset>
                <legend>Enregistrer Lieu</legend>
               <input type="hidden" name="id_lieu" value="<?php echo $currentId; ?>" />
			<table>
			<tr>
				<td>Nom :&nbsp;</td>
				<td><input type="text" name="nom_lieu" value="<?php echo $nom_lieu; ?>"/></td>
			</tr>
                         <tr>
				<td>Adresse :&nbsp;</td>
				<td><input type="text" name="adresse_lieu" rows="12" cols="100" value="<?php echo $adresse_lieu; ?>"/></td>
			</tr>
                        <tr>
				<td>Description :&nbsp;</td>
                                <td><textarea name="description_lieu" value="<?php echo $description_lieu; ?>"/></textarea></td>
			</tr>
                       
                        <tr>
				<td>Catégorie :&nbsp;</td>
				<td><select name="categorie_id_categorie">
					<option value="">choisissez</option>
					<?php foreach ($categoriesList as $curCategorie) : ?>
					<option value="<?php echo $curCategorie['id_categorie']; ?>"<?php echo $id_categorie== $curCategorie['id_categorie'] ? ' selected="selected"' : ''; ?>><?php echo $curCategorie['nom_categorie']; ?></option>
					<?php endforeach; ?>
                                    </select>
				
			</tr>
                         <tr>
				<td>Ville :&nbsp;</td>
				<td><select name="ville_id_ville">
					<option value="">choisissez</option>
					<?php foreach ($villesList as $curVille) : ?>
					<option value="<?php echo  $curVille['id_ville']; ?>"<?php echo $id_ville== $curVille['id_ville'] ? ' selected="selected"' : ''; ?>><?php echo $curVille['nom_ville']; ?></option>
					<?php endforeach; ?>
                                    </select>
				
			</tr>
                         <tr>
				<td>Code Postal :&nbsp;</td>
				<td><select name="codePostale_id_codePostale">
					<option value="">choisissez</option>
					<?php foreach ($codePostauxList as $curCodePostale) : ?>
					<option value="<?php echo $curCodePostale['id_codePostale']; ?>"<?php echo $id_codePostale== $curCodePostale['id_codePostale'] ? ' selected="selected"' : ''; ?>><?php echo $curCodePostale['cp_codePostale']; ?></option>
					<?php endforeach; ?>
                                    </select>
				
			</tr><tr>
				<td></td>
				<td><input type="submit" value="<?php if ($currentId > 0) { echo 'Modifier'; } else { echo 'Ajouter'; } ?>"/></td>
			</tr>	
			</table>
                        
            </fieldset>
        </form>

    </body>
</html>
