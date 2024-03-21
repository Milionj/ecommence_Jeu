<?php  

require 'bdd.php';
$db = Database::connect();
session_start();

if(isset($_GET['id'])){

    $query = "SELECT produits.*, categories.nomcateg FROM produits, categories WHERE categories.id = produits.categorie_id AND produits.id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Récupérer l'ID de la nouvelle catégorie
    $query_categories = "SELECT * FROM categories;";
    $stmt_categories = $db->prepare($query_categories);
    $stmt_categories->execute([]);
    $categories = [];
    while ($categorie = $stmt_categories->fetch(PDO::FETCH_ASSOC)) {
        // Parcourir les lignes de résultat et les stocker dans le tableau $categories.
        $categories[] = $categorie;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="containerOfAllProduct">
        <form id="zuqdfo" action="modificationfinale.php" method="post" class="container2 container2qdif">
        
        <?php    
            if($produit){
                
            ?>
                <input name="idproduit" type="hidden" value="<?php echo $produit['id'];?>">
                <div class="conn">
                    Nom : 
                    <input name="nomprod" type="text" value="<?php echo $produit['nom'];?>">
                </div>
                <div class="conn">
                    Description : 
                    <input name="description" type="text" value="<?php echo $produit['description'];?>">
                </div>
                <div class="conn">
                    Prix : 
                    <input name="prix" type="number" value="<?php echo $produit['prix'];?>">
                </div>
                <div class="conn">
                    Quantité : 
                    <input name="qte" type="text" value="<?php echo $produit['qte'];?>">
                </div>
                <div class="conn">
                    Nom de Catégorie : 
                
                   <select name="idcateg">
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['nomcateg']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php 
            }
        ?>

            <div class="rowBtn">
               <a href="modifier.php?id=<?php echo $produit['id']; ?>">Annuler la modification</a>
                &nbsp;&nbsp;
                <button
                    type="submit"
                    name="sauvegarderLesModifs"
                >
                    Sauvegarder
                </button>
                </div>
        
        </form>
    </div>
</body>
</html>
