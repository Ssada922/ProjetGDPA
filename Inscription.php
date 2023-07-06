<?php 
session_start();//Ouverture de la session
ob_start(); // Demarrage de la mise en tempon
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/styleAuth.css" />
<meta name="viewport" content="width = device-width, initial-scale=1, user-scalable=no"/>
<title>Inscription</title>
</head>
<body>
<?php 
include_once('Configuration.php'); //Connexion a la base...
$messageMail = 'Votre adresse email est invalide'; //Initialisation des variable messages
$messageTel = 'Votre numéro de téléphone est invalide.';
$messageSuc = ''; 
          if(isset($_POST['inscrire'])){ //Verifions si le formulaire est soumis

               if(!empty($_POST['prenom']) && !empty($_POST['nom']) 
                  && !empty($_POST['phone']) && !empty($_POST['age']) && 
                  !empty($_POST['sexe']) && !empty($_POST['password'])){ // Verifions si aucun champs n'est vide

                    $prenom = htmlspecialchars($_POST['prenom']); //Recupertion des donnees du formulaire contre l'injection de code
                    $prenom = stripslashes($prenom); //Contre les antislashs
                    $prenom = trim($prenom); //Contre l'espace blanc
           
                    $nom = htmlspecialchars($_POST['nom']);
                    $nom = stripslashes($nom);
                    $nom = trim($nom);
           
                    $phone = htmlspecialchars($_POST['phone']);
                    $phone = stripslashes($phone);
                    $phone = trim($phone);
           
                    $sexe = htmlspecialchars($_POST['sexe']);
                    $sexe = stripslashes($sexe);
                    $sexe = trim($sexe);
           
                    $age = htmlspecialchars($_POST['age']);
                    $age = stripslashes($age);
                    $age = trim($age);
                    
                    $password = htmlspecialchars($_POST['password']); //J'avais enlever ca lors du hachage
                    $password = stripslashes($password);
                    $password = trim($password);
                    $password = hash('sha512',$password);

                      if(preg_match('/^(70|75|76|77|78)\d{7}$/', $phone)){ //Verifions si le  numéro de téléphone est valide.
                          $insert = "INSERT INTO  `personnels` (prenom, nom, phone, sexe, age, statut, password) VALUES (:prenom, :nom, :phone, :sexe, :age, 'personnel', :password)"; //Requete d'insertion utilisateur
                          $resultat = $pdo->prepare($insert); //Prepartion de la requete
                          $resultat->bindParam(":prenom", $prenom, PDO::PARAM_STR);   //Liaison des paramètres aux variables 
                          $resultat->bindParam(":nom", $nom, PDO::PARAM_STR);
                          $resultat->bindParam(":phone", $phone, PDO::PARAM_INT);
                          $resultat->bindParam(":sexe", $sexe,  PDO::PARAM_STR);
                          $resultat->bindParam(":age", $age, PDO::PARAM_INT);
                          $resultat->bindParam(":password", $password, PDO::PARAM_STR);
                          $resultat->execute(); //Execution de la requete
                            # echo "Votre numéro de téléphone est valide.";

                          $select = "SELECT * FROM personnels WHERE phone = :phone AND password = :password ";
                          $result = $pdo->prepare($select);
                          $result->bindParam(":phone", $phone, PDO::PARAM_INT);   //Liaison des paramètres aux variables 
                          $result->bindParam(":password", $password, PDO::PARAM_STR);
                          $result->execute();

                               if($result->rowCount()>0){ //Si un utilisateur est  trouvé
                                   $ligne = $result->fetch(PDO::FETCH_ASSOC); //Recuperation de la ligne d'infos
                                   $id_pers = $ligne['id_pers']; //Recuperation de l'id dans le tableau $ligne
                                   $_SESSION['id_pers'] = $id_pers; //Stockage  de l'id dan la variable session
                                   $prenom = $ligne['prenom']; //Recuperation du prénom de l'utilisateur
                                   $_SESSION['prenom'] = $prenom; //Stockage du prénom dans un variable session
                                   $_SESSION['phone'] = $phone; //Ouverture session
                                   $_SESSION['password'] = $password;     
                                        
                                       if($ligne['statut'] == 'personnel'){
                                          $messageSuc = "Bravo, vous êtes inscrit avec succès.";
                                          header("refresh:3;url=AccueilPersonnel.php");
                                       }else{
                                          $messageSuc = "Bravo, vous êtes inscrit avec succès.";
                                          header("refresh:3;url=Acceuil_Administrateur.php");
                                       }
                                   

                               }else{
                                # echo "Aucun uttilisateur trouvé"
                               }

                      }else{
                        header("refresh:3;url=Inscription.php");
                        echo "<p class ='msgSucces' >".$messageTel."<p>";
                      }
              }else{
               # echo"Aucun champs ne doit pas etre vide";
              }

          }else{
          # echo 'Veuiller valider le formualaire';
           $nettoieTempon = ob_get_clean(); //Netoyyage du contenu en tempon
          echo $nettoieTempon;
          }

?> 
<section id="section" >
                       <header></header>
                       <aside></aside>
                       <article></article>
    <main>     
      <form class="container" action="" method="post">
        
         <div>
            <label class="label" for="pre">Prénom</label></br>
            <input id="pre" class="formInput" type="text" name="prenom" placeholder="Votre prénom" required/></br>
            <label class="label" for="nm">Nom</label></br>
            <input id="nm" class="formInput" type="text" name="nom" placeholder="Votre nom" required/></br>
            <label class="label" for="tel">Numéro téléphone</label></br>
            <input id="tel" class="formInput" type="text" name="phone" placeholder="Votre numéro téléphone" required/></br> 
            <p class="form-phrase">Déjà inscrit? 
            <a href="Index.php">Connectez-vous ici</a></p>
         </div> 
         <div> 
             <label class="label" >Sexe</label></br>
                <select class="formInputSelect" type="text"  name="sexe">
                 <option>Masculin</option>
                 <option>Feminin</option>
                </select>
             <label class="label">Age</label>
                <select class="formInputSelect" type=""  name="age">
                  <?php for($age = 18; $age<=60; $age++): ?>
                    <option values = "" ><?=$age; ?></option>
                  <?php endfor; ?>
                </select>
             <label class="label" for="mdp">Mot de passe</label></br>
            <input id="mpd" class="formInput" type="password" name="password" placeholder="Votre mot de passe" minlength="8" required/>
            <input class="formbutton" type="submit" name="inscrire" value="S'inscrire" required/>
         </div>
           <?php
           if(!empty($messageSuc)): ?>
           <p class="msgSucces" ><?= $messageSuc;?></p>
           <?php endif; ?>
      </form>
   
    </main>
    <footer></footer>
        </section>
   
</body>
</html>
