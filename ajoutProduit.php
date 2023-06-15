<?php
 session_start();
 ob_start();
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
        if(isset($_POST['ajouter'])){
            if(isset($_POST['libelle']) && !empty($_POST['libelle']) && isset($_POST['description']) && $_POST['description']){
                $libelle = htmlspecialchars($_POST['libelle']);
                $libelle = stripslashes($libelle);
                $libelle = trim($libelle);

                $description = htmlspecialchars($_POST['description']);
                $description = stripslashes($description);
                $description = trim($description);

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
                $msgErr = "Veuillez renseigner tous les champs";

            }

        }else{
            echo"";
        }
        ?>
        
             <div class="divButOuvrirPop">
                <p>Cliquer sur le boutton "ouvrir le popup" pour ajouter une Categorie.</p>
                <button class="butOuvrirPop" onclick="ouvertureFormulaire()"><strong>Ouvrir le popup</strong></button>
             </div>

        <div class="divForm" id="monPopup">
            <form class="formContainer" method="post" action="">
                <h2 class="h1Form" >Ajout Catégories</h2>
                <label class="formLab" for="lib">Libellé</label>
                <input class="formInput" name="libelle" id="lib"  type="text"  placeholder="Votre libellé"  required>
                <label class="formLab" for="desc">Description</label>
                <textarea class="formInput" name="description" id="desc" cols="30" rows="10" ></textarea>
                <input class="butSubmit" type="submit" name="ajouter" value="Ajouter">
                <input class="butSubmitFerm" type="button" name="" value="Fermer" onclick="fermetureFormulaire()" >
            </form>
            <?php if(!empty($msgErr)){  ?>
               <p class="msgErreur"><?php echo $msgErr; ?></p>
               <?php } ?>
        </div>
        <!--Script permettant l'ouverture et la fermeture du formulaire-->
        <script> 
          //Pour la fonction d'ouverture j'utilise diplay:block pour rendre visible en faite le formulaire
            function ouvertureFormulaire() {
              document.getElementById("monPopup").style.display = "block";
            }
        //Pour la fonction de fermeture j'utilise le le diplay:none pour masquer en faite le formulaire
            function fermetureFormulaire() {
              document.getElementById("monPopup").style.display = "none";
            }
          </script>
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
                            <td colspan="2">
                              <div class="imContainer">
                                <a  class='' href="modifierCategories.php?id_cat=<?=$recupCategories['id_cat'];?>"> <img  class="iconeTableau" width="" height="" src="iconeMod.jpg" alt=""></a>
                                <a  class='' href="supprimerCategories.php?id_cat=<?=$recupCategories['id_cat'];?>"> <img class="iconeTableau" width="" height="" src="iconeSup.jpg" alt=""></a>
                              </div>
                            </td>
                        </tr>
                        <?php } ?>
                     </table>       
    </body>
</html>
