<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Initialiser la session -->
    <?php
    session_start();
    ?>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.html">BDD AP-Mission 2</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="livres.php">Livres</a></li>

                    <?php
                    // Vérifier si l'utilisateur est connecté
                    if (isset($_SESSION['id'])) {
                        // Ajouter l'option de déconnexion
                        echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="deconnexion.php">Déconnexion</a></li>';
                    } else {
                        // Ajouter les options de connexion et d'inscription si l'utilisateur n'est pas connecté
                        echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="connexion.php">Se connecter</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header-->
    <header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>Connexion</h1>
                        <span class="subheading">Connectez-vous à votre compte</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <!-- Formulaire de connexion -->
                <form action="connexion.php" method="POST">
                    <div class="mb-3">
                        <label for="id" class="form-label">Identifiant</label>
                        <input type="text" class="form-control" id="id" name="id" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>

                <!-- Traitement de la soumission du formulaire -->
                <?php
                    // Récupération des données du formulaire
                    $id = $_POST['id'] ?? "";
                    $mdp = $_POST['mdp'] ?? "";

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Connexion à la base de données avec PDO
                    $dsn = "mysql:host=localhost;dbname=gsb_praticienCompletee;charset=utf8";

                    try {
                        $conn = new PDO($dsn, $id, $mdp);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        die("Échec de la connexion à la base de données : " . $e->getMessage());
                    }

                    // Requête pour vérifier les identifiants
                    $stmt = $conn->prepare("SELECT nom FROM utilisateur WHERE nom = ?");
                    $stmt->execute([$id]);
                    $user = $stmt->fetchColumn();

                    $sqlMdp = $conn->prepare("SELECT mdp FROM utilisateur WHERE nom = ?");
                    $sqlMdp->execute([$id]);
                    $mdpBDD = $sqlMdp->fetchColumn();

                    // Vérification du résultat
                    if ($user && ($mdp == $mdpBDD)) {
                        // Stocker les informations de l'utilisateur dans la session
                        $_SESSION['id'] = $user;

                    } else {
                        // Afficher un message d'erreur si les identifiants sont incorrects
                        echo "<p>Identifiant ou mot de passe incorrect. Veuillez réessayer.</p>";
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
