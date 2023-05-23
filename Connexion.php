<?php  
//Initialisation de la session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="styleAuth.css" />
  <meta name="viewport" content="width = device-width, initial-scale=1, user-scalable=no"/>
<title>Connexion</title>
</head>
<body>
<?php
   //Connexion a la base de donnee
   require('configuration.php'); 

       if (isset($_POST['phone']) && !empty($_POST['phone'])){ 
           $phone = htmlspecialchars($_POST['phone']);
           $phone = mysqli_real_escape_string($conn, $phone);
           $_SESSION['phone'] = $phone;
           $password = htmlspecialchars($_POST['password']);
           $password = mysqli_real_escape_string($conn, $password);
         //Requete de selection  du numero de telephone et du mot de passe de l'utilisateur(Admin/Personnel)
           $req = "SELECT * FROM personnels WHERE phone='$phone' and password='$password'";/*".hash('sha256', $password)."*/
  
                $req1 = mysqli_query($conn,$req) or die(mysql_error());
  
            if (mysqli_num_rows($req1) == 1) {

                    $personnel = mysqli_fetch_assoc($req1);

                // vérifier si l'utilisateur est un administrateur ou un utilisateur
                    if ($personnel['statut'] == 'admin') {
                       
                        header('location: Acceuil_Administrateur.php');
                       
                       }else{
                        
                        header('location: AccueilPersonnel.php'); 
                       
             }
       }else{
                 $msgerreur = "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
 }
?>
                <form class="container" action="" method="post" name="login">
                        <h1 class="form-titre">Connexion</h1>
                    <input type="int" class="form-input" name="phone" placeholder="Numero telephone">
                    <input type="password" class="form-input" name="password" placeholder="Mot de passe">
                    <input type="submit" value="Se Conneter" name="submit" class="form-button">
                    <p class="form-phrase">Vous êtes nouveau ici?<a class="con" href="Inscription.php">S'inscrire</a></p>

           <?php if (! empty($msgerreur)) { ?>
    <p class="msgErreur"><?php echo $msgerreur; ?></p>
<?php } ?>
</form>
</body>
</html>
