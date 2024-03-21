<?php  

require 'bdd.php';
$db = Database::connect();
session_start();

if(isset($_POST['sauvegarderLesModifs'])){
    $idproduit = $_POST['idproduit'];
    $nomprod = $_POST['nomprod'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $qte = $_POST['qte'];
    $idCateg = $_POST['idcateg'];

    $query = "UPDATE produits SET nom = ?, description = ?, prix = ?, qte = ?, categorie_id = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$nomprod, $description, $prix, $qte, $idCateg, $idproduit]);
   
    $rowsAffected = $stmt->rowCount();
    echo "Nombre de lignes affectées : " . $rowsAffected;

}
?>
 