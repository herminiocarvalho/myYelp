<pre>
    <?php
    require 'include/config.php';

    $currentId = 0;
    $lieuRes = array();
// Je récupère le paramètre d'URL "page" de type integer
    if (isset($_GET['id'])) {
        $currentId = intval($_GET['id']);
    }
      $sql = 'SELECT
            `nom_lieu`,
            `adresse_lieu`,
            ville.nom_ville,
            `description_lieu`,
            categorie.nom_categorie,
            ville.nom_ville,
            codepostale.cp_codePostale
            FROM
              `lieu`
            INNER JOIN
              categorie ON categorie.id_categorie = `categorie_id_categorie`
            INNER JOIN
              ville ON ville.id_ville = `ville_id_ville`
            INNER JOIN
              codepostale ON codepostale.id_codePostale = `codePostale_id_codePostale`
             WHERE id_lieu = :Idlieu';

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':Idlieu', 1);

    if ($pdoStatement->execute() && $pdoStatement->rowCount() > 0) {
        $lieuRes = $pdoStatement->fetchall();
        print_r($lieuRes);
    }

    ;
    ?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
     
         

    <legend>Affichage du Lieu</legend>
    
      
            <table>
                
                 
					
					<option value="<?php echo $lieuRes['nom_lieu']; ?>"</option>
                                        <option value="<?php echo $lieuRes['adresse_lieu']; ?>"</option>
                                        <option value="<?php echo $lieuRes['description_lieu']; ?>"</option>
                                        <option value="<?php echo $lieuRes['codepostale.cp_codePostale']; ?>"</option>
            </table>
        </fieldset>
   
</body>
</html>

</pre>