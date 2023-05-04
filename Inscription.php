<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styleAuth.css" />
<meta name="viewport" content="width = device-width, initial-scale=1, user-scalable=no"/>
<title>Inscription</title>
</head>
<body>
<?php 
  require 'configuration.php'; //Connexion a la base de donnee GDPA

     if (isset($_POST['prenom']) && !empty($_POST['prenom']) && isset($_POST['nom']) && //Testons si les variables existent et qu'elles sont non nulles
     !empty($_POST['nom']) && isset($_POST['phone']) && !empty($_POST['phone']) 
     && isset($_POST['sexe']) && !empty($_POST['sexe']) && isset($_POST['age'])
      && !empty($_POST['age']) && isset($_POST['password']) && !empty($_POST['password'])){
        //Recuperation des valeurs des variables avec securite
          $prenom = htmlspecialchars($_POST['prenom']); 
          $prenom = mysqli_real_escape_string($conn, $prenom);

          $nom = htmlspecialchars($_POST['nom']);
          $nom = mysqli_real_escape_string($conn, $nom);

          $phone = htmlspecialchars($_POST['phone']);
          $phone = mysqli_real_escape_string($conn, $phone);

          $sexe = htmlspecialchars($_POST['sexe']);
          $sexe = mysqli_real_escape_string($conn, $sexe);

          $age = htmlspecialchars($_POST['age']);
          $age = mysqli_real_escape_string($conn, $age);

          $password = htmlspecialchars($_POST['password']);
          $password = mysqli_real_escape_string($conn, $password);
           //Creation du requete d'insertion des valeurs de la variable dans la table
             $req = "INSERT into `personnels` (prenom, nom, phone, sexe, age, statut, password)
        VALUES ('$prenom', '$nom', '$phone', '$sexe', '$age', 'personnel', '$password')";/*".hash('sha256', $password)."*/
              $reqtemp = mysqli_query($conn, $req);

                  if($reqtemp){
                    echo "<div class='msgReussi'>
                    <h2>Vous êtes inscrit avec succès.</h2>
                    <p>Cliquez ici pour vous <a classe='msgReussii' href='Connexion.php'>connecter</a></p>
                    </div>";
           }

       }else{
   ?>
               <form class="container" action="" method="post">
                     <h1 class="form-titre">S'inscrire</h1>
                     <input type="text" class="form-input" name="prenom"  placeholder="Votre prenom" required />
                     <input type="text" class="form-input" name="nom"  placeholder="Votre nom" required />
                     <input type="int" class="form-input" name="phone"  placeholder="Votre numero de telephone" required />
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
                      <select type="text" class="input-choix" name="sexe">
                        <option>Masculin</option>
                        <option>Feminin</option>
                      </select>
                     <input type="password" class="form-input" name="password" placeholder="Votre mot de passe" minlength = "8" required />
                     <input type="submit" name="submit" value="S'inscrire" class="form-button" />
                     <p class="form-phrase">Déjà inscrit? 
                     <a href="Connexion.php">Connectez-vous ici</a></p>
               </form>
<?php } ?>
</body>
</html>