<?php
require 'bdd.php';


$db = Database::connect();

if(isset($_GET['id']) && is_numeric($_GET['id'])){
  $id = htmlspecialchars($_GET['id']);
  $query = 'SELECT * FROM produits WHERE id = :id';
  $stmt = $db->prepare($query);
  $stmt -> execute(['id' =>$id]);
  $produit = $stmt->fetch(PDO::FETCH_ASSOC);
}



Database::disconnect();

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Détail </title>
  <link rel="stylesheet" href="index.css">
</head>
<nav class="navbarProfile">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Webs_Occasion</a>
    </div>
</nav>
<body>

    
<div class="rowJJ">
<img class="imgProduct" src="img/<?= htmlspecialchars($produit['img']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>">

</div>
<div class="rowJO">
  <h5 class="card-title"><?= htmlspecialchars($produit['nom']); ?></h5>
</div> 
<div class="rowJO">
<p class="card-text"><?= htmlspecialchars($produit['description']); ?></p>

</div>          
<div class="rowJO">
<p class="price"><?= htmlspecialchars($produit['prix']); ?>€</p>

</div> 
<div class="rowJO">
<a href="addPanierREQ.php?id=<?php  echo $produit["id"];  ?>">Ajouter au panier</a>

</div> 

        



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>