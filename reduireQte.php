<?php

require 'bdd.php';
$db = Database::connect();
session_start();

if(isset($_GET['id'])){

    $qte = 0;

    $query = "SELECT * FROM panier WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($result[0]["qte"] >= 1){
        $query = "UPDATE panier SET qte = qte-1 WHERE id = ? ";
        $stmt = $db->prepare($query);
        $stmt->execute([$_GET['id']]);
    }
    
}

header("Location: panier.php");

?>