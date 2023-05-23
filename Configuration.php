<?php
  $host = 'localhost';
  $dbname = 'gdpa';
  $username = 'root';
  $password = '';
          try{

           $pdo = new PDO("mysql: host = $host; dbname = $dbname", $username, $password);
          // echo"Vous avez connecté à la base de données $dbname avec succès en tant que $username"; ca s'affiche dans la page raison pour laquelle j'ai commente
           $pdo->exec("USE $dbname");

        }catch(PDOException $e){
           echo $e->getMessage();
           exit();
  }
