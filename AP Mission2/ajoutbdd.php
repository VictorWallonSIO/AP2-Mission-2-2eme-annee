<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>AP - Mission 2 - Site Web</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <!-- Initialiser la session -->
    <?php
    session_start();
    ?>
    <body>
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

                    <?php
                    // Vérifier si l'utilisateur est connecté
                    if (isset($_SESSION['id'])) {
                        // Ajouter l'option de déconnexion
                        echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="deconnexion.php">Déconnexion</a></li>';
                        echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="index.php">Accueil</a></li>';
                    }
                    else {
                        header("Location: index.php");
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
                            <h1>Gestion de la base de données AP</h1>
                            <span class="subheading">Gestion des praticiens de la région Bretagne</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <!-- Post preview-->
                    <div class="post-preview">

                        <h2 class="post-title">Bienvenue sur le site de la BDD AP - Mission 2 !</h2> <br>
                        <h3 class="post-subtitle">Vous êtes sur la page de gestion <br> <br> Vous pouvez gérer tout les practiciens 
                        de la région avec les options qui vous sont proposé</h3>

                    </div>
                </div> <br> <br>

                <form action="#" method="POST">
                <input type="text" name="nom" placeholder="Nom">
                <input type="text" name="prenom" placeholder="Prenom">
                <input type="text" name="adresse" placeholder="Adresse">
                <input type="text" name="code_type" placeholder="Code type praticien"> 
                <br><br>
                <button type="submit" name="ajout" class="btn btn-pra">Ajouter</button>
                </form>

                <?php

                if(isset($_POST["ajout"])) {
                    ajouter();
                }

                    function ajouter() {
                        try 
                        {
                            $nom = $_POST["nom"] ?? "";
                            $prenom = $_POST["prenom"] ?? "";
                            $adresse = $_POST["adresse"] ?? "";
                            $code_type = $_POST["code_type"] ?? "";
                            
                            $pdo = new PDO ("mysql:host=172.22.48.38;dbname=gsb_praticienCompletee",$_SESSION['id'],$_SESSION['mdp']) ?? "";
    
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            
                            $verif_code = false;
                            $tab_code_type = ["MV","MH","PH","PO","PS",
                        "mv","mh","ph","po","ps"];

                            foreach($tab_code_type as $i) 
                            {
                                if($code_type == $i) 
                                {
                                    $verif_code = true;
                                    break;
                                }
                            }

                            if($verif_code) 
                            {
                                $affichage_praticien = $pdo->prepare("INSERT INTO praticien VALUES (?,?,?,?,?,?,?,?,?)");
                                $affichage_praticien->execute(array(null,$nom,$prenom,"1234",$adresse,0,0,$code_type,11032));
                                echo "<p class='vert'> Ajout fait avec succès </p>";
                            }
                            else 
                            {
                                echo "<p id='message'>Erreur lors de l'insertion : le code type n'existe pas : </p>";
                            }
                        }
                        catch (PDOException $e) 
                        {
                            echo "<p id='message'>Erreur lors de l'insertion' : </p>" . $e->getMessage();
                        }

                        }                

    ?>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>