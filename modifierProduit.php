<?php
  session_start();
  include_once('Configuration.php');

  if(isset($_GET['id_prod']) && !empty($_GET['id_prod'])){
    $id = $_GET['id_prod'];
      $req = "SELECT * FROM produits WHERE id_prod = ?";
      $statement = $pdo->prepare($req);
      $statement->execute([$id]);

         if($statement->rowCount()>0){
            $myRows = $statement->fetch(PDO::FETCH_ASSOC);
            $id_cat =$myRows['id_cat'];
            $libelle = $myRows['libelle'];
            $poids = $myRows['poids'];
            $prix = $myRows['prix'];
            $date_expiration = $myRows['date_expiration'];

              if(isset($_POST['ajouter'])){

                  if(!empty($_POST['libelle']) && !empty($_POST['poids']) &&
                   !empty($_POST['prix']) && !empty($_POST['date_expiration']) && !empty($_POST['categorie'])):
                     
                     $libelleSaisi = htmlspecialchars($_POST['libelle']);
                     $libelleSaisi = stripslashes($libelleSaisi);
                     $libelleSaisi = trim($libelleSaisi);
                     $poidsSaisi = htmlspecialchars($_POST['poids']);
                     $poidsSaisi = stripslashes($poidsSaisi);
                     $poidsSaisi = trim($poidsSaisi);
                     $prixSaisi = htmlspecialchars($_POST['prix']);
                     $prixSaisi = stripslashes($prixSaisi);
                     $prixSaisi = trim($prixSaisi);
                     $dateSaisi = htmlspecialchars($_POST['date_expiration']);
                     $dateSaisi = stripslashes($dateSaisi);
                     $dateSaisi = trim($dateSaisi);
                     $id_cat = htmlspecialchars($_POST['categorie']); 
                     $id_cat = stripslashes($id_cat);
                     $id_cat = trim($id_cat);

                          $update ="UPDATE produits SET id_cat = ?, libelle = ?, poids = ?, prix = ?, date_expiration = ? WHERE id_prod = ?";
                          $res = $pdo->prepare($update);
                          $res->execute([$id_cat, $libelleSaisi, $poidsSaisi, $prixSaisi, $dateSaisi, $id]);

                                 echo  " <p class='msgReussi'>Le produit a été modifié avec succès à la base de données.</p> ";
                                 header("refresh:3; url = ajoutProduit.php"); 
                          
                  endif;

              }else{

              }

         }else{

         } 
}else{
  
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Formulaire modification de produit avec Popup</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/StyleformPupup.css">
    </head>
    <body>
                      
             <script>
                    function ouverturePopup(){
                        var afficher = document.getElementById("monPopup");
                        afficher.style.display = "block";
                     }

                    function fermeturePopup(){
                        var fermer = document.getElementById("monPopup");
                        fermer.style.display = "none";
                     }
             </script>

             <div class="divButOuvrirPop">
                <p>Cliquer sur le boutton "ouvrir le popup" pour ajouter une Categorie.</p>
                <button class="butOuvrirPop" onclick="ouverturePopup()"><strong>Ouvrir le popup</strong></button>
             </div>
        
        <div class="divForm" id="monPopup">
            <form class="formContainer" method="post" action="">
                <h2 class="h1Form" >modification de Produit</h2>
                <!--Liste deroulante pour choisir une categories -->
                <label  class="formLab" for="deroulante">Categorie</label>
                    <select class="list" name="categorie" id="deroulante">
                       <?php $recupCat = "SELECT * FROM categories";
                               $recupCat = $pdo->query($recupCat);
                                 while($categorie = $recupCat->fetch(PDO::FETCH_ASSOC)):?>
                        <option  value="<?php echo $categorie['id_cat']; ?>"><?php echo $categorie['libelle'];?></option>
                        <?php endwhile; ?>
                    </select>

                <label class="formLab" for="lib">Libelle</label>
                <input class="formInput" id="lin" type="text" name="libelle" placeholder="Riz" value="<?=$libelle; ?>" required>
                <label class="formLab" for="poi">Poids</label><br>
                <input  class="formInput" id="poi" type="" name="poids" placeholder="6kg" value="<?=$poids; ?>" required>
                <label class="formLab" for="prx">Prix</label><br>
                <input  class="formInput" id="prx" type="" name="prix" placeholder="1500" value="<?=$prix; ?>" required>
                <label class="formLab date"   for="lib">Date d'expiration</label>
                <input  class="formInput" id="lin" type="date" name="date_expiration" placeholder="mm/jj/aaaa" value="<?=$date_expiration; ?>" required>
                <input class="butSubmit" type="submit" name="ajouter" value="Ajouter">
                <input class="butSubmitFerm" type="button" name="" value="Fermer" onclick="fermeturePopup()" >
            </form>
        </div>
    </body>
</html>