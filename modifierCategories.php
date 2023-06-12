<?php
 session_start();
 ob_start();
 include_once('Configuration.php');
 
$libelle ='';
$description ='';
    if(isset($_GET['id_cat']) && !empty($_GET['id_cat'])){
     $recupId = $_GET['id_cat'];
     $selectCat = "SELECT * FROM categories WHERE id_cat = ?"; 
     $resultat = $pdo->prepare($selectCat);
     $resultat->execute(array($recupId));
          if($resultat->rowCount()>0){
              $infosCategories = $resultat->fetch(PDO::FETCH_ASSOC);
              $libelle = $infosCategories['libelle'];
              $description = $infosCategories['description'];
                  if(isset($_POST['ajouter'])){
                         $libelleSaisi = htmlspecialchars($_POST['libelle']);
                         $libelleSaisi = trim($libelleSaisi);
                         $libelleSaisi = stripslashes($libelleSaisi);
                         $descriptionSaisi = htmlspecialchars($_POST['description']);
                         $descriptionSaisi = trim($descriptionSaisi);
                         $descriptionSaisi = stripslashes($descriptionSaisi);

                         $updateCat = "UPDATE categories SET libelle = ?, description = ? WHERE id_cat = ?";
                         $updateCat =  $pdo->prepare($updateCat);
                         $updateCat->execute(array($libelleSaisi, $descriptionSaisi, $recupId));
                                         echo  " <p class='msgReussi'>La catégorie a été modifiée avec succès à la base de données.</p> ";
                                         header("refresh:3;url=ajoutCategories.php");   
              }else{
                     echo"";
              }
            }
          }else{
            echo"";
          
}
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
               <script>
                function ouverturePopup(){
                    //Appliquons dans le document l'element qui a l'id(monPopup) la valeur block
                    var afficher = document.getElementById("monPopup");
                    afficher.style.display = "block";
                }
                    //Appliquons dans le document l'element qui a l'id(monPopup) la valeur none
                function fermeturePopup(){
                    var fermer = document.getElementById("monPopup");
                    fermer.style.display = "none";
                }
               </script>
            <div class="divButOuvrirPop">
                <p>Cliquer sur le boutton "ouvrir le popup" pour modifier une Categorie.</p>
                <button class="butOuvrirPop" onclick="ouverturePopup()"><strong>Ouvrir le popup</strong></button>
            </div>

            <div class="divForm" id="monPopup">
               <form class="formContainer" method="post" action="">
                   <h2 class="h1Form" >Ajout Catégories</h2>
                   <label class="formLab" for="lib">Libellé</label>
                   <input class="formInput" name="libelle" id="lib"  type="text"  placeholder="Votre libellé" value="<?=$libelle;?>" required>
                   <label class="formLab" for="desc">Description</label>
                   <textarea class="formInput" name="description" id="desc" cols="30" rows="10" ><?=$description;?></textarea>
                   <input class="butSubmit" type="submit" name="ajouter" value="Ajouter">
                   <input onclick="fermeturePopup()" class="butSubmitFerm" type="button" name="" value="Fermer">
               </form>
            </div>
               <?php if(!empty($smsErr)){  ?>
                 <p class="msgErreur"><?php echo $smsErr; ?></p>
               <?php } ?>
    </body>
</html>
