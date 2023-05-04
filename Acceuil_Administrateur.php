<?php
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION['phone'])){
    header("Location: Connexion.php");
    exit(); 
  }
  ?>
<!DOCTYPE html>
<html> 
    <head>
        <title>Acceuil_Administrateur</title>
        <meta charset="utf8" >
        <meta name="viewport" content="width = device-width, initial-scale=1, user-scalable=no"/>
        <title>Administrateur</title>
        <link rel="stylesheet" href="Admin.css" >
    </head>
    <body>
      <a href="Deconnexion.php">Deconnexion</a>
    </body>
</html>