<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Webs_Occasion</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Connectez-vous</h2>
        <form action="connectionREQ.php" method="post">
            <div class="mb-3">
                <label for="mail" class="form-label">Votre e-mail</label>
                <input type="email" class="form-control" id="mail" name="mail" required>
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="pwd" name="mdp" required>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>

        <!-- Ajout d'un message d'erreur en cas d'échec de la connexion -->
        <?php if(isset($_GET['error']) && $_GET['error'] == 'auth_failed'): ?>
            <div class="alert alert-danger mt-3" role="alert">
                Identifiants invalides. Veuillez réessayer.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
