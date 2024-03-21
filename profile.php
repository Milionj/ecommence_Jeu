<?php

session_start();
require 'bdd.php';
$db= Database::connect();


$produits = [];


$stmt = $db->prepare('SELECT * FROM produits'); // Préparer une requête SQL pour sélectionner toutes les lignes de la table 'produits'.
$stmt->execute([]);

while ($produit = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Parcourir les lignes de résultat et les stocker dans le tableau $produits.
    $produits[] = $produit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page </title>
    <link rel="stylesheet" href="index.css">
    
</head>
<body>

<nav class="navbarProfile">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Webs_Occasion</a>
    </div>
</nav>





    <div class="containerOfAllProduct">
        <div class="container2">
    <?php 
    
        if($_SESSION['estAdmin']){
          //il est admin 
          foreach ($produits as $produit) {
            // Faites quelque chose avec chaque élément du tableau $produits.
    ?>
        <div class="rowDeProduits">
            <?php 
                echo $produit['nom']."&nbsp;&nbsp;".$produit['prix']."€";
            ?>

            <a class="btnModifier" href="modifier.php?id=<?php echo $produit['id']; ?>">Modifier</a>
            <a class="btnSupprimer"  href="suppProduit.php?id=<?php echo $produit['id']; ?>">Supprimer</a>

        </div>        
    <?php 
            }
        }
        else{
            // n est pas admin 
        
    ?>
        <!--  pas admin  ...-->
        <button>
            Ne click pas 
        </button>
    <?php 
        }
    ?>
    </div>
    </div>

    
</body>

</html>