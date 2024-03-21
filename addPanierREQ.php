<?php
session_start();
require 'bdd.php';

if (!isset($_SESSION['userId'])) {
    header('Location: connexion.php');
    exit; // Terminer le script pour éviter toute exécution supplémentaire
}

$userId = $_SESSION['userId'];
$produitId = $_GET['id'];
$qte = 1;

try {
    $db = Database::connect();

    // Récupérer le produit sur lequel on a cliqué
    $stmt = $db->prepare('SELECT * FROM produits WHERE id = ?');
    $stmt->execute([$produitId]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produit || $produit['qte'] < $qte) {
        // Gérer le cas où le produit n'est pas trouvé ou la quantité en stock est insuffisante
        throw new Exception("Le produit n'est pas disponible en quantité suffisante.");
    }

    // Commencer une transaction
    $db->beginTransaction();

    // Décrémenter la quantité en stock du produit
    $newqteProd = $produit['qte'] - $qte;
    $upStmt = $db->prepare('UPDATE produits SET qte = ? WHERE id = ?');
    $upStmt->execute([$newqteProd, $produitId]);

    // Vérifier si le produit est déjà dans le panier de l'utilisateur
    $query = 'SELECT * FROM panier WHERE produit_id = ? AND user_id = ?';
    $stmt = $db->prepare($query);
    $stmt->execute([$produitId, $userId]);
    $panierProd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($panierProd) {
        // Mettre à jour la quantité dans le panier
        $newQtePanier = $panierProd['qte'] + 1;
        $upStmt = $db->prepare('UPDATE panier SET qte = ? WHERE id = ?');
        $upStmt->execute([$newQtePanier, $panierProd['id']]);
    } else {
        // Ajouter le produit au panier
        $dateAdd = (new DateTime())->format('Y-m-d H:i:s');
        $issertStmt = $db->prepare('INSERT INTO panier (produit_id, qte, user_id, date) VALUES (?, ?, ?, ?)');
        $issertStmt->execute([$produitId, $qte, $_SESSION['userId'], $dateAdd]);
    }

    // Valider la transaction
    $db->commit();

    // Redirection vers la page du panier
    header('Location: panier.php');
    exit;
} catch (Exception $e) {
    // Gérer les erreurs
    echo "Erreur : " . $e->getMessage();
    // Annuler la transaction en cas d'erreur
    $db->rollBack();
} finally {
    // Déconnexion de la base de données
    Database::disconnect();
}
?>
