<?php
   session_start(); //Initialisation de la session
     if(!isset($_SESSION['phone'])){
        header('location: index.php');
        exit();
     }
?>
<!DOCTYPE html>
  <html>
    <head>
        <title>accueilPersonnel</title>
        <meta charset="utf-8"  >  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Personnel.css">
    </head>
      <body>
     
        <section class="container" >
           <header>
                 <nav>  
                   <img class="img" width="" height="" src="logoaccueil.png" alt="">
                   <h2>Market Enterprise<strong>.</strong></h2>
                   <ul><li><a href="AccueilPersonnel.php">Accueil</a></li></ul>
                   <ul><li><a href="boutique.php">Boutique</a></li></ul>
                   <ul><li><a href="Deconnexion.php">Deconnexion</a></li></ul> 
                   <ul><li><a class="butNav" href="AjoutDeProduit">+Ajouter un produit</a></li></ul>
                  </nav>
           </header>
           <main>
            <img class="imgMain" src="accueilPersonnel.png" alt="">
           </main>
           <aside class="containerAside">
            <div class="items1" >
              <h1>Transformer votre</br>entreprise</h1>
            <!--</div>-->
                <div class="items2" >
                   <p>Bienvenue sur la page d'accueil du personnel de notre site de gestion de produit alimentaire. Cette page est destinée à vous fournir les outils nécessaires pour gérer les produits, les stocks, les commandes et les clients.
                      Nous sommes convaincus que cette plateforme facilitera votre travail et vous aidera à gérer efficacement vos tâches.</p>
                </div>
            </div>
            <div class="items3">
               <button><a href="#">Les personnels</a></button>
            </div>
           </aside>
           <footer>
            <p>Tous droits réservés aux personnels de l'entreprise &copy coparight Juin 2023</p>
           </footer>
        </section>   
      </body>
  </html>
