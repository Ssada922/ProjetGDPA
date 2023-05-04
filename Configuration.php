<?php //Connexion a la base de donne GDPA
 define('DB_SERVER','localhost');
 define('DB_USERNAME','Ssada');
 define('DB_PASSWORD','09-02-2002');
 define('DB_NAME','gdpa');
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
     if($conn === false){
            
       die("ERREUR: Impossible de se connecter a la base de donee.".mysqli_connect_error());
     }
?>