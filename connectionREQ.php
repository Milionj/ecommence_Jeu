<?php
require 'bdd.php';
$db = Database::connect();
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = htmlspecialchars($_POST['mail']);
    $mdp = htmlspecialchars($_POST['mdp']);

    // Vérifier si l'utilisateur existe en bdd avec le mail
    $stmt = $db -> prepare('SELECT * FROM clients WHERE email = :email');
    $stmt -> execute(['email' => $email]);
    $user = $stmt -> fetch(PDO::FETCH_ASSOC);

    //  Vérifier si l'utilisateur existe et si le mot de passe est correct 
    if($user && password_verify($mdp, $user['mdp'])){
        $_SESSION['userId'] = $user['id'];
        $_SESSION['estAdmin'] = $user['estAdmin'];
        header('Location: index.php');
    }else{
        $error = 'Email ou mot de passe incorrect';
        echo "alert('password incorrect')";
        header('Location: connexion.php?error=' . $error);
    }

}

Database::disconnect();