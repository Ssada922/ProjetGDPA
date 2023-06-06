<?php 
//Ouverture de la session
  session_start();
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
 // require 'configuration.php';
  include_once('Configuration.php'); //Connexion a la base de donnee GDPA
     if (isset($_POST['prenom']) && !empty($_POST['prenom']) && isset($_POST['nom']) && //Testons si les variables existent et qu'elles sont non nulles
     !empty($_POST['nom']) && isset($_POST['phone']) && !empty($_POST['phone']) 
     && isset($_POST['sexe']) && !empty($_POST['sexe']) && isset($_POST['age'])
      && !empty($_POST['age']) && isset($_POST['password']) && !empty($_POST['password'])){

        //Recuperation des valeurs des variables avec securite
          $prenom = htmlspecialchars($_POST['prenom']); 
          $prenom= stripslashes($prenom);

          $nom = htmlspecialchars($_POST['nom']);
          $nom = stripslashes($nom);

          $phone = htmlspecialchars($_POST['phone']);
          $phone = stripslashes($phone);

          $sexe = htmlspecialchars($_POST['sexe']);
          $sexe = stripslashes($sexe);

          $age = htmlspecialchars($_POST['age']);
          $age = stripslashes($age);
          
          $password = htmlspecialchars($_POST['password']); //J'avais enlever ca lors du hachage
          $password = stripslashes($password);
          $password = hash('sha512',$password);
          //Hachage du mot de passe
        //  $passwordHash = password_hash($_POST['password'], PASSWORD_ARGON2I);
         

           //Creation du requete d'insertion des valeurs de la variable dans la table
           $req =  "INSERT INTO `personnels` (prenom, nom, phone, sexe, age, statut, password) VALUES (:prenom, :nom, :phone, :sexe, :age, 'personnel', :password)";

           //Preparation de la requete
              $reqtemp = $pdo->prepare($req); 

           //Liaison des paramètres au nom de variable
              $reqtemp->bindParam(":prenom", $prenom, PDO::PARAM_STR);    
              $reqtemp->bindParam(":nom", $nom, PDO::PARAM_STR);
              $reqtemp->bindParam(":phone", $phone, PDO::PARAM_INT);
              $reqtemp->bindParam(":sexe", $sexe,  PDO::PARAM_STR);
              $reqtemp->bindParam(":age", $age, PDO::PARAM_INT);
              $reqtemp->bindParam(":password", $password, PDO::PARAM_STR);

              //On execute la requete
              $reqtemp->execute();

              //Recuperation du numero de telephone et du mot de passe de l'utilisateur
              $reqSelect = "SELECT * FROM personnels WHERE phone = :phone AND password = :password ";

              //Preparation de le requete
              $recupPersonnel = $pdo->prepare($reqSelect);

              //Liaison des paramètres au nom de variable
              $recupPersonnel->bindParam(":phone", $phone, PDO::PARAM_INT);
              $recupPersonnel->bindParam(":password", $password, PDO::PARAM_STR);
              
              //Execution de la requete
              $recupPersonnel->execute();

              //Verification si on a trouve un utilisateur avec la fonction rowCount()
              $rowCount = $recupPersonnel->rowCount();
              if($rowCount>0){
                 //Ouverture d'une session a cet utilisateur
                 $_SESSION['phone'] = $phone;
                 $_SESSION['password'] = $password;

                 //Redirection dans la page d'accueil des personnels
                 $msgInsSucces = "Bravo, vous êtes inscrit avec succès.";

                // header('location:AccueilPersonnel.php');
                 header("refresh:3;url=AccueilPersonnel.php");

              }else{

              } 
               //  echo "<div class='msgReussi'>
                //  <h2>Vous êtes inscrit avec succès.</h2>
                //   <p>Cliquez ici pour vous <a classe='msgReussii' href='Connexion.php'>connecter</a></p>
                //   </div>";
            
          }else{

          }
          $nettoieTempon = ob_get_clean(); //Netoyyage du contenu en tempon
          echo $nettoieTempon;
   ?>
               <form class="containerIns" action="" method="post">
                     <h1 class="form-titre">S'inscrire</h1>
                     <label class="label">Prenom</label>
                     <input type="text" class="form-inputIns" name="prenom"  placeholder="Votre prenom" required />
                     <label class="label">Nom</label>
                     <input type="text" class="form-inputIns" name="nom"  placeholder="Votre nom" required />
                     <label class="label">Numero de téléphone</label>
                     <input type="int" class="form-inputIns" name="phone"  placeholder="Votre numero de téléphone" required />
                     <label class="label">Age</label>
                     <select type="int" class="input-choix"  name="age">
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                        <option>21</option>
                        <option>22</option>
                        <option>23</option>
                        <option>24</option>
                        <option>25</option>
                        <option>26</option>
                        <option>27</option>
                        <option>28</option>
                        <option>29</option>
                        <option>30</option>
                        <option>31</option>
                        <option>32</option>
                        <option>33</option>
                        <option>34</option>
                        <option>35</option>
                        <option>36</option>
                      </select>
                      <label class="label">Sexe</label>
                      <select type="text" class="input-choix" name="sexe">
                        <option>Masculin</option>
                        <option>Feminin</option>
                      </select>
                      <label class="label">Mot de passe</label>
                     <input type="password" class="form-inputIns" name="password" placeholder="Votre mot de passe" minlength = "8" required />
                     <input type="submit" name="submit" value="S'inscrire" class="form-button" />
                     <p class="form-phrase">Déjà inscrit? 
                     <a class="hrefbas" href="Index.php">Connectez-vous ici</a></p>
                     <?php
            if(!empty($msgInsSucces)){ ?>
    <p class="msgErreur"><?php echo $msgInsSucces; ?></p>
           <?php } ?>
       </form>
   
</body>
</html>
