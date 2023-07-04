<?php
session_start();
ob_start();
   if(!isset($_SESSION['id_pers'])){
    header("Location: Index.php");
    exit(); 
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Formulaire d'ajout de produit avec Popup</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/StyleformPupup.css">
    </head>
    <body>
<?php 
include_once('Configuration.php');
             if(isset($_POST['ajouter'])){
                if(isset($_POST['libelle']) && !empty($_POST['libelle']) && isset($_POST['poids']) &&
                 !empty($_POST['poids']) && isset($_POST['prix']) && !empty($_POST['prix'])
                && isset($_POST['date_expiration']) && !empty($_POST['date_expiration'])){

                 $libelle = htmlspecialchars($_POST['libelle']); //N'accepte pas du code html, javascipt...
                 $libelle = stripslashes($libelle); //N'accepte pas les slash
                 $libelle = trim($libelle); //N'accepte pas les espaces blanches

                 $poids = htmlspecialchars($_POST['poids']);
                 $poids = stripslashes($poids);
                 $poids = trim($poids);

                 $prix = htmlspecialchars($_POST['prix']);
                 $prix = stripslashes($prix);
                 $prix = trim($prix);
                 
                 $date_expiration = htmlspecialchars($_POST['date_expiration']);
                 $date_expiration = stripslashes($date_expiration);
                 $date_expiration = trim($date_expiration);

                 $id_pers = $_SESSION['id_pers']; //Stockage de id_pers qui est dans la variable session dans $id_cat
                 $id_cat = $_POST['categorie']; //Recuperation de la valeur choisi dans la menu deroulante
                 $req = "SELECT id_cat FROM categories WHERE id_cat = :id_cat";  
                 $resultat = $pdo->prepare($req);
                 $resultat->bindValue(":id_cat", $id_cat);
                 $resultat->execute();
                    if($resultat->rowCount()>0){ 
                       $infos =  $resultat->fetch(PDO::FETCH_ASSOC);

                          if(isset($infos['id_cat']) && !empty($infos['id_cat'])){ 
                             
                            $insertProduit = "INSERT INTO Produits(libelle, poids, prix, date_expiration, id_pers, id_cat) VALUES (:libelle, :poids, :prix, :date_expiration, :id_pers, :id_cat)";

                            $statment = $pdo->prepare($insertProduit);
                            $statment->bindValue(":libelle", $libelle);
                            $statment->bindValue(":poids", $poids);
                            $statment->bindValue(":prix", $prix);
                            $statment->bindValue(":date_expiration", $date_expiration);
                            $statment->bindValue(":id_pers", $id_pers);
                            $statment->bindValue(":id_cat", $id_cat);
                            $insertOK = $statment->execute();

                                if($insertOK){
                                    echo  " <p class='msgReussi'>Le produit a été ajouté avec succès à la base de données.</p> ";
                                    header("refresh:3; url = ajoutProduit.php"); 
                               }else{
                                    echo"Votre produit n'a pas pu ajouter à la base de données";
                      }

                }else{
                    echo "";
                }
                
            }else{
                echo"";
            }
        }
    }  
        ?>

             <div class="divButOuvrirPop">
                <p>Cliquer sur le bouton "ouvrir le popup" pour ajouter un produit.</p>
                <button class="butOuvrirPop" onclick="ouvertureFormulaire()"><strong>Ouvrir le popup</strong></button>
             </div>

                            <!-- Recuperation des categories -->
         <?php 
          $recup = "SELECT * FROM categories";
          $recupCat = $pdo->query($recup);
                   ?>

        <div class="divForm" id="monPopup">
            <form class="formContainer" method="post" action="">
                <h2 class="h1Form" >Ajout Produit</h2>
                <!--Liste deroulante pour choisir une categories -->
                <label class="formLab" for="deroulante">Categorie</label>
                     <select class="list" name="categorie" id="deroulante">
                       <?php while($infosCat = $recupCat->fetch(PDO::FETCH_ASSOC)):?>
                          <option class="contenuListe" value="<?php echo $infosCat['id_cat']; ?>"><?php echo $infosCat['libelle']?></option>
                       <?php endwhile ?>
                     </select></br>
                <label class="formLab" for="lib">Libelle</label>
                <input class="formInput" id="lin" type="text" name="libelle" placeholder="Riz" required>
                <label class="formLab" for="poi">Poids</label><br>
                <input  class="formInput" id="poi" type="" name="poids" placeholder="4kg" required>
                <label class="formLab" for="prx">Prix</label><br>
                <input  class="formInput" id="prx" type="" name="prix" placeholder="1500" required>
                <label class="formLab date"   for="lib">Date d'expiration</label>
                <input  class="formInput" id="lin" type="date" name="date_expiration" placeholder="mm/jj/aaaa" required>
                <input class="butSubmit" type="submit" name="ajouter" value="Ajouter">
                <input class="butSubmitFerm" type="button" name="" value="Fermer" onclick="fermetureFormulaire()" >
            </form>
        </div>

        <section id="container" >
                 <table class="myTable" >
                       <tr>
                          <th>Libelle</th>
                          <th>Poids</th>
                          <th>Prix</th>
                          <th>Date expiration</th>
                          <th>Actions</th>
                       </tr>
                       <?php 
                       $req = "SELECT * FROM produits"; //Requete de selection des produits
                       $monResultat = $pdo->query($req); //Execution de la requete
                       while( $produit = $monResultat->fetch(PDO::FETCH_ASSOC)):
                       ?>
                       <tr>
                          <td><?=$produit['libelle']; ?></td>
                          <td><?=$produit['poids']; ?></td>
                          <td><?=$produit['prix']; ?></td>
                          <td><?=$produit['date_expiration']; ?></td>
                          <td colspan="2" >
                            <div class="imContainer" >
                              <a  class='' href="modifierProduit.php?id_prod=<?=$produit['id_prod'];?>"> <img  class="iconeTableau" width="" height="" src="iconeMod.jpg" alt=""></a>
                              <a href="supprimerProduit.php?id_prod=<?=$produit['id_prod']; ?>"> <img  class="iconeTableau" width="" height="" src="iconeSup.jpg" alt=""></a>
                            </div>
                          </td>
                       </tr>
                       <?php endwhile; ?>
                 </table>
        </section>

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
    </body>
</html>


