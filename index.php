<?php //Initialisation de la session
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="styleAuth.css" />
  <meta name="viewport" content="width = device-width, initial-scale=1, user-scalable=no" />
  <title>Connexion</title>
</head>

<body>
  <?php
  //Connexion a la base de donnee
  //require('configuration.php');
  include_once('Configuration.php'); //Connexion a la base de donnees

  if (isset($_POST['phone']) && !empty($_POST['phone'])) {
    $phone = htmlspecialchars($_POST['phone']);
    $phone = stripslashes($phone);
    $_SESSION['phone'] = $phone;
    $password = htmlspecialchars($_POST['password']);
    $password = stripslashes($password);
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
    if ($rowCount > 0) {
      $personnel =  $reqtemp->fetch(PDO::FETCH_ASSOC);

      //Verification:si l'utilisateur est admin ou personnel
      if ($personnel['statut'] == 'admin') {

        header('location: Acceuil_Administrateur.php');
      } else {

        header('location: AccueilPersonnel.php');
      }
    } else {

      $msgerreur = "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
  }

  ?>
  <form class="container" action="" method="post" name="">
    <h1 class="form-titre">Connexion</h1>
    <label class="label">Numero de téléphone</label>
    <input type="int" class="form-input" name="phone" placeholder="Numero telephone">
    <label class="label">Mot de passe</label>
    <input type="password" class="form-input" name="password" placeholder="Mot de passe">
    <input type="submit" value="Se Connecter" name="submit" class="form-button">
    <p class="form-phrase">Vous êtes nouveau ici?<a class="hrefbas" href="Inscription.php">S'inscrire</a></p>

    <?php if (!empty($msgerreur)) { ?>
      <p class="msgErreur"><?php echo $msgerreur; ?></p>
    <?php } ?>
  </form>
</body>

</html>