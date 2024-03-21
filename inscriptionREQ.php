<?php
require 'bdd.php';
$db = Database::connect();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom = htmlspecialchars($_POST['nom']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = htmlspecialchars($_POST['mdp']);


    // Vérifier si un utilisateur existe déjà en bdd avec le même mail
    $stmt = $db->prepare('SELECT id FROM clients WHERE email = :mail');
    $stmt->execute(['mail' => $mail]);
    if($stmt->fetch()){
        $error ='Cet email est déjà utilisé';
        header('Location: inscription.php?error=' . $error);
        exit;   
    }


// Hasher un mot de passe 
//  la fonction password_hash(), effectue le 'salage' automatiquement
// Un sel est une chaîne de caractères aléatoire qui est ajoutée au mot de passe avant le hachage. Cela rend le hashage unique même si deux clients ont le même mot de passe.
// Permet de protéger contre les attaques par rainbow table ( table de hashage)
//  PASSWORD_DEFAULT : utilise l'algoriythme Bcrypt pour hasher les mots de passe 
    $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);

    $stmt = $db->prepare('INSERT INTO clients (nom, email, mdp) VALUES (:nom, :mail, :mdp)');
    $success = $stmt->execute(['nom' => $nom, 'mail' => $mail, 'mdp' => $mdpHash]);

    if($success){
        header('Location: connexion.php');
    }else{
        $error = 'Erreur lors de l\'inscription';
        header('Location: inscription.php?error=' . $error);}
    }

Database::disconnect();