<?php 
    include_once('Configuration.php');
     if(isset($_GET['id_prod']) && !empty($_GET['id_prod'])){
        $myId = $_GET['id_prod'];
            $recupId = "SELECT * FROM produits WHERE id_prod = ?";
            $isSelect = $pdo->prepare($recupId);
            $isSelect->execute(array($myId));
              if($isSelect->rowCount()>0){
                  $deleteId = "DELETE FROM produits WHERE id_prod = ?";
                  $isDelete = $pdo->prepare($deleteId);
                  $isDelete->execute(array($myId));
                    header('location:ajoutProduit.php');
             }else{
                echo"";
             }
     
    }else{

 }
?>