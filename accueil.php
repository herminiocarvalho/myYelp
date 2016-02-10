<?php
require 'include/config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
	<title>Accueil MyYelp</title>

</head>
<style>
    body{
        font-family:arial;
        font-size:.8em;
    }
     
    input[type=text]{
        padding:0.5em;
        width:20em;
    }
     
    input[type=submit]{
        padding:0.4em;
    }
     
    #gmap_canvas{
        margin: auto;
        width:80%;
        height:30em;
    }
     
    #map-label,
    #address-examples{
        margin:1em 0;
    }
    </style>


 
<header>
	<h1>Accueil<span> Bienvenue SUR MyYelp</span></h1>
</header>
<section id="connexionZone">
	<h2>MAP GOOGLE</h2>
	<a href="accueil.php" border="0" />Accueil</a>
</section>
<?php
$sql = 'SELECT    
                `id_lieu`,
                `nom_lieu`,
                `adresse_lieu`,
                `ville_id_ville`,
                `description_lieu`,
                `codePostale_id_codePostale`,
                `categorie_id_categorie`,
                `lati_lieu`,
                `long_lieu`
              FROM
                `lieu`';
       
	$pdoStatement = $pdo->query($sql);
	if ($pdoStatement && $pdoStatement->rowCount() > 0) {
		$resList = $pdoStatement->fetchall();
              //  echo'<pre>';
	        // print_r($resList[0]);
           //     echo'<pre/>';
		
	}
        
 // On initialise la carte        
       $latitude = 49.5578;
       $longitude = 5.98095;
                     
   
       ?>
 
    <!-- google map will be shown here -->
    <div id="gmap_canvas">Loading map...</div>
   <!-- <div id='map-label'>Map shows approximate location.</div> -->
 
    <!-- JavaScript to show google map -->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js"></script> 
    <script type="text/javascript">
        function init_map() {
            var myOptions = {
               
                zoom: 11,
                center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
            
            <?php foreach ($resList as $key => $value) : ?>
            marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(<?php echo $value['lati_lieu']; ?>, <?php echo $value['long_lieu']; ?>)
            });
            <?php endforeach; ?>
          
        }
        google.maps.event.addDomListener(window, 'load', init_map);
    </script>
 
<body>
	<main>
            <section>
		<ul>
                      <?php foreach ($resList as $key => $value) : ?>
                    <li><a href="afficherLieu.php?id=<?php echo $value['id_lieu']; ?>" border="0" /><?php echo $value['nom_lieu']; ?></a></li>
			 <?php endforeach; ?>
			
		</ul>
	</section>
</main>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

</body>
</html>



   
   


    
    
      
        
         
         
         
         
         
         
         
         
      
      
         
      
    
  
  
     
         
         
    
     
    
 
    
 
   
  
   
   

  

  


 
  
   
   
  
      
        

         


        


        

  


    
     
         
  