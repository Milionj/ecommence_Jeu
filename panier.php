<?php
require 'bdd.php';
session_start();
$db = Database::connect();
$userTemp = $_SESSION['userTemp'] ?? null;
$userId = $_SESSION['userId'] ?? null;

// Extraction des catégories parentes
$queryParentCategs = 'SELECT * FROM categories WHERE parent IS NULL';
$stmtParentCategs = $db->prepare($queryParentCategs);
$stmtParentCategs->execute();
$parentCategs = $stmtParentCategs->fetchAll(PDO::FETCH_ASSOC);

// Extraction des catégories enfants
$queryChildCategs = 'SELECT * FROM categories WHERE parent IS NOT NULL';
$stmtChildCategs = $db->prepare($queryChildCategs);
$stmtChildCategs->execute();
$childCategs = $stmtChildCategs->fetchAll(PDO::FETCH_ASSOC);

if (!empty($userId)) {
    $query = 'SELECT panier.*, produits.nom, produits.prix 
              FROM panier
              INNER JOIN  produits ON panier.produit_id = produits.id
              WHERE user_id = ?';
    $stmt = $db->prepare($query);
    $stmt->execute([$userId]);
    $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $query = 'SELECT pa.*, p.nom, p.prix 
              FROM panier
              INNER JOIN  produits ON pa.produit_id = p.id 
              WHERE userTemp = ? AND user_id IS NULL';
    $stmt = $db->prepare($query);
    $stmt->execute([$userTemp]);
    $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Calcul du nombre total d'éléments dans le panier
$count = count($panier);

$totalPanier = 0;

Database::disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-commerceJeu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <?php foreach ($parentCategs as $categ) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= htmlspecialchars($categ['nomcateg']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($childCategs as $childCateg) {
                                    if ($childCateg['parent'] === $categ['id']) { ?>
                                        <li><a class="dropdown-item" href="index.php?categ=<?php echo htmlspecialchars($childCateg['id']); ?>"><?= htmlspecialchars($childCateg['nomcateg']); ?></a></li>
                                <?php }
                                } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['userId'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['estAdmin']) { ?>
                                    <li><a class="dropdown-item" href="profile.php">Dashboard</a></li>
                                <?php } ?>
                                <li><a class="dropdown-item" href="panier.php">Panier</a></li>
                                <li><a class="dropdown-item" href="deconnection.php">Déconnexion</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a id="inscription" class="nav-link" href="inscription.php">Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php">Connexion</a>
                        </li>
                    <?php } ?>

                    <?php if (isset($_SESSION['userId'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="panier.php">
                                <i class="bi bi-bag"></i>
                            </a>
                            <span class='badge bg-primary'>
                                Panier : <?php echo $count; ?>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <h2 class="iqdyhfsc">Votre Panier</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Produit</th>
                <th scope="col">Quantité</th>
                <th scope="col">Prix unitaire</th>
                <th scope="col">Prix total</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($panier as $item) : ?>
                <tr>
                    <th scope="row"><?= htmlspecialchars($item['nom']); ?></th>
                    <td>
                        <a href="ajoutQte.php?id=<?php echo $item['id']; ?>">+</a>
                        <span><?= htmlspecialchars($item['qte']); ?></span>
                        <a href="reduireQte.php?id=<?php echo $item['id']; ?>">-</a>
                   
                        </td>
                    <td><?= htmlspecialchars($item['prix']); ?>€</td>
                    <td><?= $item['prix'] * $item['qte']; ?>€</td>
                    <td>
                        <a href="supprimerproduit.php?id=<?php echo $item['id']; ?>">Supprimer</a>
                    </td>
                </tr>
                <?php $totalPanier += $item['prix'] * $item['qte']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total panier:</th>
                <td><?= $totalPanier; ?>€</td>
            </tr>
        </tfoot>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
