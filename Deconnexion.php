<?php
    session_start(); //Initialisation de la session
      if(session_destroy()){ //Destruction de la session puis redirection vers la page de connexion
          header('location: index.php');
      }
