<?php
    session_start();
    include_once('Configuration.php');
    //Testons si l'id_prod existe et qu'il est non vide
    if(isset($_GET['id_cat']) && !empty($_GET['id_cat'])){
        $recupId = $_GET['id_cat']; //stockage dans un autre variable pour etre simple
        $selectId = "SELECT * FROM categories WHERE id_cat = ?"; //Requete de selection de l'id
        $resultat = $pdo->prepare($selectId); //Preparation de la requete
        $resultat->execute(array($recupId)); //Execution de la requete
          if($resultat->rowCount()>0){ //Si on a trouve un resultat
             $deletecat =  "DELETE FROM categories WHERE id_cat = ?"; //Requete suppression categories
             $delCat = $pdo->prepare($deletecat);           //Preparation de la requete
             $delCat->execute(array($recupId));             //Execution de la requete
             header('location:ajoutCategories.php');        //Redirection dans la meme page
          }else{ 
          echo"Aucun categories n'a ete trouve";
        }
    }else{
        echo"";
    }
?>