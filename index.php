<?php
require 'bdd.php';
session_start();

// Définition des constantes
define('TABLE_CATEGORIES', 'categories');
define('TABLE_PANIER', 'panier');
define('TABLE_PRODUITS', 'produits');

$db = Database::connect();

// Fonction pour récupérer les catégories parentes
function getParentCategories($db) {
    $query = "SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent = 0";
    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer le nombre de produits dans le panier de l'utilisateur
function getCartItemCount($db, $userId) {
    $query = "SELECT COUNT(*) AS count FROM " . TABLE_PANIER . " WHERE user_id = :userId";
    $stmt = $db->prepare($query);
    $stmt->execute(['userId' => $userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

// Fonction pour récupérer les produits en fonction de la catégorie
function getProductsByCategory($db, $categoryId) {
    if ($categoryId !== null) {
        $query = 'SELECT * FROM ' . TABLE_PRODUITS . ' WHERE categorie_id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$categoryId]);
    } else {
        $query = 'SELECT * FROM ' . TABLE_PRODUITS;
        $stmt = $db->query($query);
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération des catégories parentes et enfants
$parentCategs = getParentCategories($db);
$childCategs = $db->query("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent != 0")->fetchAll(PDO::FETCH_ASSOC);

// Récupération du nombre de produits dans le panier
$count = isset($_SESSION['userId']) ? getCartItemCount($db, $_SESSION['userId']) : 0;

// Récupération des produits en fonction de la catégorie sélectionnée
$categ_id = isset($_GET['categ']) ? $_GET['categ'] : null;
$produits = getProductsByCategory($db, $categ_id);

Database::disconnect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> ecommerceJeu </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="index.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><strong>Webs_Occasion</strong></a>
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

              <?php
              
              if($_SESSION['estAdmin']){

                ?>
                <li><a class="dropdown-item" href="profile.php">Dashboard</a></li>

                <?php
              }
              ?>
                <li><a class="dropdown-item" href="panier.php">Panier  </a></li>
                <li><a class="dropdown-item" href="deconnection.php">Déconnexion</a></li>
              </ul>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a id="inscription"  class="nav-link" href="inscription.php">Inscription</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="connexion.php">Connexion</a>
            </li>
          <?php } ?>
        <?php 

            if(isset($_SESSION['userId'])){
              
          ?>

          <li class="nav-item">
            <a class="nav-link" href="panier.php">
              <i class="bi bi-bag"></i>
            </a>
            <span class='badge bg-primary'>
            Panier  : <?php echo $count; ?>
            </span>
          </li>

          <?php 
            }

        ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">

      <?php foreach ($produits as $produit) { ?>
          <div class="card cardX" style="width: 18rem;">
            <img src="img/<?= $produit['img']; ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($produit['nom']); ?></h5>
              <p class="card-text"><?= htmlspecialchars($produit['description']); ?>.</p>
              <p class="card-text"><?= htmlspecialchars($produit['prix']); ?>.</p>
              <div class="d-flex justify-content-between">
                <a href="details.php?id=<?php echo $produit['id']; ?>" class="btn btn-primary me-1">Voir les détails</a>
                <a id="ajouTpanier" href="addPanierREQ.php?id=<?php echo $produit['id']; ?>"  >Ajouter au panier</a>
              </div>
            </div>
          </div>
      <?php } ?>


  </div>






    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="index.js" ></script>    

</body>

</html>