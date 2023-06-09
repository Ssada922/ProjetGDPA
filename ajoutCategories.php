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
<?php
$minLib = 3;
$maxLib = 200;
$minDes = 15;
$maxDes = 250;
$message = 'Le libellé ou description saisi n\'est pas dans</br>la fourcette du nombre de caractéres autorisées</br>
           libellé['.$minLib.' '.$maxLib.'] et description['.$minDes.' '.$maxDes.'] qui sont valides';
           ;
$msg= "Assurez-vous que les champs libelle et description ne contiennent que</br> 
        des lettres majuscules, des lettres minuscules, des chiffres et des espaces.</br>
        Veuillez à exclure tout autre type de caractère.";           
        if(isset($_POST['ajouter'])){
            if(!empty($_POST['libelle']) && !empty($_POST['description'])){
                $libelle = htmlspecialchars($_POST['libelle']);
                $libelle = stripslashes($libelle);
                $libelle = trim($libelle);

                $description = htmlspecialchars($_POST['description']);
                $description = stripslashes($description);
                $description = trim($description);
                
                 if((strlen($libelle)>=$minLib && strlen($libelle)<=$maxLib) && (strlen($description)>=$minDes && strlen($description)<=$maxDes)){
                    if(preg_match('/^[A-Za-z0-9 ]+$/', $libelle) && preg_match('/^[A-Za-z0-9 ]+$/', $description)){
                     $insertCategories = "INSERT INTO categories(libelle, description) VALUES (:libelle, :description)";
                     $statement = $pdo->prepare($insertCategories);
                     $statement->bindValue(":libelle", $libelle);
                     $statement->bindValue(":description", $description);
                     $isOk = $statement->execute();
                       if($isOk){
                         echo  " <p class='msgReussi'>La catégories a été ajouté avec succès à la base de données.</p> ";
                         header("refresh:3;url=ajoutCategories.php");
                      }else{
                         echo  " <p class='msgReussi'>Votre catégories n'a pas pu ajouter à la base de données.</p> ";
                         header("refresh:3;url=ajoutCategories.php");
                      }

                    }else{
                     header("refresh:7;ajoutCategories.php");
                     echo "<p class ='msgEchec' >".$msg."</p>";
                    }

                  }else{
                     header("refresh:7;ajoutCategories.php");
                     echo "<p class ='msgEchec' >".$message."</p>";
                     
                  }

            }else{
               # echo = "Aucun champ ne doit etre vide";

            }

        }else{
           # echo"Veuiller soumettre le formulaire";
        }
        ?>
        
             <div class="divButOuvrirPop">
                <p>Cliquer sur le boutton "ouvrir le popup" pour ajouter une Categorie.</p>
                <button class="butOuvrirPop" onclick="ouverturePopup()"><strong>Ouvrir le popup</strong></button>
             </div>

        <div class="divForm" id="monPopup">
              <form class="formContainer" method="post" action="">
               <h2 class="h1Form" >Ajout Catégories</h2>
               <label class="formLab" for="lib">Libellé</label>
               <input class="formInput" name="libelle" id="lib"  type="text"  placeholder="Votre libellé"  required>
               <label class="formLab" for="desc">Description</label>
               <textarea class="formInput" name="description" id="desc" cols="30" rows="10" ></textarea>
               <input class="butSubmit" type="submit" name="ajouter" value="Ajouter">
               <input onclick="fermeturePopup()" class="butSubmitFerm" type="button" name="" value="Fermer">
              </form>
        </div>
        <!--Script permettant l'ouverture et la fermeture du formulaire-->
        <script> 
          //Pour la fonction d'ouverture j'utilise diplay:block pour rendre visible en faite le formulaire
            function ouverturePopup() {
              document.getElementById("monPopup").style.display = "block";
            }
        //Pour la fonction de fermeture j'utilise le le diplay:none pour masquer en faite le formulaire
            function fermeturePopup() {
              document.getElementById("monPopup").style.display = "none";
            }
          </script>
           <!--<section id="container" >-->
                     <table class="maTable">
                        <tr>
                            <th>Libellé</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        <?php 
                        $selectCat = "SELECT * FROM categories";
                        $recupCat = $pdo->query($selectCat);
                     while($recupCategories = $recupCat->fetch(PDO::FETCH_ASSOC)){ ?>
                        <tr>
                            <td><?=$recupCategories['libelle']; ?></td>
                            <td><?=$recupCategories['description']; ?></td>
                            <td class="largeurAction" >
                              <div class="imContainer">
                                <a  class='' href="modifierCategories.php?id_cat=<?=$recupCategories['id_cat'];?>"> <img  class="iconeTableau" width="" height="" src="iconeMod.jpg" alt=""></a>
                                <a  class='' href="supprimerCategories.php?id_cat=<?=$recupCategories['id_cat'];?>"> <img class="iconeTableau" width="" height="" src="iconeSup.jpg" alt=""></a>
                              </div>
                            </td>
                        </tr>
                        <?php } ?>
                     </table>    
           <!-- </section>   -->
    </body>
</html>