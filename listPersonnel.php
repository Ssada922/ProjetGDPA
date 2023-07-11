<?php
session_start();
ob_start();
if(!isset($_SESSION['id_pers'])){
    header("Location: Index.php");
    exit(); 
  }
     $id_pers = $_SESSION['id_pers'];
 include_once('Configuration.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Formulaire d'ajout de categories avec Popup</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/StyleformPupup.css">
    </head>
    <body>
         <table class="tablePersonnel">
           <tr>
              <th>Prénom</th>
              <th>Nom</th>
              <th>Numéro téléphone</th>
              <th>Sexe</th>
              <th>Age</th>
              <th>Action</th>
           </tr>
<?php 
   $req = "SELECT * FROM Personnels WHERE statut = 'personnel' ORDER BY nom ASC";
   $personnel = $pdo->prepare($req);
   $personnel->execute();
   $variable = $personnel->fetchall();
     foreach ($variable as  $value) : ?>
           <tr>
              <td><?=$value['prenom']; ?></td>
              <td><?=$value['nom']; ?></td>
              <td><?=$value['phone']; ?></td>
              <td><?=$value['sexe']; ?></td>
              <td><?=$value['age']; ?></td>
              <td class='actionSup' ><a  class='' href="supprimerCategories.php?id_cat=<?=$recupCategories['id_cat'];?>"> <img class="iconeTableau" width="" height="" src="iconeSup.jpg" alt=""></a></td>
            </tr>
<?php endforeach; ?>
       </table>       
    </body>
</html>