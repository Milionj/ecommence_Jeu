<?php  

require 'bdd.php';
$db = Database::connect();
session_start();

if(isset($_GET['id'])){


    $query = "DELETE FROM produits WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    
    
}

header("Location: profile.php");







?>