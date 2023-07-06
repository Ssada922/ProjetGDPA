<?php
session_start(); // Initialiser la session
ob_start();
   if(!isset($_SESSION['id_pers'])){ // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
    header("Location: index.php");
    exit(); 
  }
  $id_pers = $_SESSION['id_pers'];
  ?>
<!DOCTYPE html>
<html> 
    <head>
        <title>Acceuil_Administrateur</title>
        <meta charset="utf8" >
        <meta name="viewport" content="width = device-width, initial-scale=1, user-scalable=no"/>
        <title>Administrateur</title>
        <link rel="stylesheet" href="css/Admin.css" >
    </head>
    <body>
      <section id="container" >

         <header>
           <nav class="">
                   <h2>Market <span>Enterprise</span><strong>.</strong> </h2>
              <ul class="">
              <li><a href="#">Accueil</a></li>
              <li><a href="#">Boutique</a></li>
              <li><a href="#">Personnels</a></li>
              <li><a href="Deconnexion.php">Deconnexion</a></li>
              </ul>
              <button type="button" ><a href="ajoutCategories.php">Creer Categories</a></button>
           </nav>
         </header>
         <aside>
          <?php echo"<p class='msgBienvenue'>Bienvenue ".$_SESSION['prenom']."</p>"; ?></aside>
         <main>MAIN</main>
         <footer>FOOTER</footer>

      </section>
    </body>
</html>
