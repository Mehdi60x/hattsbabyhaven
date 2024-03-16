<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/3fe3cc7820.js" crossorigin="anonymous"></script>
    <title>Hatt's Baby Haven.</title>
</head>
<body>
    <header>
        <h1>Hatt's Baby Haven.</h1>
        <nav>
            <ul>
                <li><a href="/accueil">Accueil</li></a>
                <li><a href="#produits">Nos produits</li></a>
                <li><a href="#Contact">Contactez-nous</li></a>
                <li><a href="/connexion">Suivre ma commande</li></a>
                <div class="iconenav">
                <i class="fa-solid fa-magnifying-glass"></i>
                <?php if(!isset($_SESSION['user']['id'])){ ?>
                    <a href="connexion"><i class="fa-solid fa-user"></i></a>
                <?php } else { ?><a href="deconnexion">Déconnexion</a>
                    <a href="profil"><i class="fa-solid fa-user" style="color: #09bd03;"></i></i></a>
                    <?php } ?>
                <i class="fa-solid fa-bag-shopping"></i>
            </ul>
            
<!-- Création d'une 2eme Nav Bar pour le responsive -->
            <ul id="responsiveNav">
                <li><a href="/accueil">Accueil</li></a>
                <li><a href="#produits">Nos produits</li></a>
                <li><a href="#Contact">Contactez-nous</li></a>
                <li><a href="/connexion">Suivre ma commande</li></a>
                <div class="iconenav">
                <i class="fa-solid fa-magnifying-glass"></i>
                <?php if(!isset($_SESSION['user']['id'])){ ?>
                    <a href="connexion"><i class="fa-solid fa-user"></i></a>
                <?php } else { ?><a href="deconnexion">Déconnexion</a>
                    <a href="profil"><<i class="fa-solid fa-user" style="color: #09bd03;"></i></a>
                    <?php } ?>
                <i class="fa-solid fa-bag-shopping"></i>
            </ul>

        </nav>
    </header>