<?php

require 'bdd.php';
$db = Database::connect();
session_start();

if(isset($_GET['id'])){


    $query = "UPDATE panier SET qte=qte+1 WHERE id = ? ";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    
    
}

header("Location: panier.php");






?>