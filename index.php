<?php 
//Initialisation de la session
       session_start(); 
       ob_start(); 
       ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/styleAuth.css" />
  <meta name="viewport" content="width = device-width, initial-scale=1, user-scalable=no"/>
<title>Connexion</title>
</head>
<body>
<?php
  //Connexion a la base de donnee
   //require('configuration.php');
   include_once('Configuration.php'); //Connexion a la base de donnees
  
       if (isset($_POST['phone']) && !empty($_POST['phone'])){ 

           $phone = htmlspecialchars($_POST['phone']);
           $phone = stripslashes($phone);
           $phone = trim($phone);
           $password = htmlspecialchars($_POST['password']);
           $password = stripslashes($password);
           $password = trim($password);
            //Hachage du mot de passe
         //  $passwordHash = password_hash($_POST['password'], PASSWORD_ARGON2I);
          $password = hash('sha512', $password);

         //Requete de selection  du numero de telephone et du mot de passe de l'utilisateur(Admin/Personnel)
           $req = "SELECT * FROM personnels WHERE phone = :phone AND password = :password";/*".hash('sha256', $password)."*/
           $reqtemp = $pdo->prepare($req);
           
           $reqtemp->bindParam(':phone', $phone);
           $reqtemp->bindParam(':password', $password);
           $reqtemp->execute();

         //Verification des resultats de le requetes
           $rowCount = $reqtemp->rowCount();   
                  if($rowCount>0){
                          $personnel =  $reqtemp->fetch(PDO::FETCH_ASSOC); //Recuperation de la ligne d'information
                          $id_pers = $personnel['id_pers']; //Recuperation de l'id du personnel dans le tableau $personnel
                          $_SESSION['id_pers'] = $id_pers; //Stockage de l'id dans la variable session
                          $prenom = $personnel['prenom']; //Recuperation du prénom de l'utilisateur
                          $_SESSION['prenom'] = $prenom; //Stockage du prénom dans un variable session
                          $_SESSION['phone'] = $phone; //Ouverture session
                          $_SESSION['password'] = $password;

                       if($personnel['statut'] == 'admin'){ //Verification:si l'utilisateur est admin ou personnel

                          header('location: Acceuil_Administrateur.php');

                      }else{

                        header('location: AccueilPersonnel.php'); 

                      }

             }else{
                 
              $msgerreur = "Le nom d'utilisateur ou le mot de passe est incorrect.";

              }

      }else{
             // echo"Veuillez saisir tous les champs";
      }
           
?>
      <section id="mysection" >
         <div class="one" >

         </div>
        <div class="two" >
            <form class="containerCon" action="" method="post">
                <h1 class="form-titre">Connexion</h1></br>
                <label class="label" for="tel">Numéro téléphone</label></br>
                <input id="tel" class="formInputcon" type="text" name="phone" placeholder="Votre numéro téléphone" /></br>
                <label class="label" for="mdp">Mot de passe</label></br>
                <input id="mdp" class="formInputcon" type="password" name="password" placeholder="Votre mot de passe" /></br>
                <input class="formbuttonCon" type="submit" name="" value="Se Connecter"/>
                <p class="form-phrase">J'ai pas de compte? 
                <a href="Inscription.php">Inscrivez-vous ici</a></p>
                <?php
              if(!empty($msgerreur)){ ?>
                <p class="msgErreur"><?=$msgerreur; ?></p>
             <?php }; ?>
            </form>
        </div>
           
      </section>
</form>
</body>
</html>
