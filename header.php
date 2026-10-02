<?php
require_once('lib/db.php');
require_once('lib/tools.php');
session_start();
if (!$_SESSION["cub_user_name"]) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="DIGI ONE - Yoan Rotru">
        <title>CUB</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    </head>
    <body>
        <header class="p-3 text-white not-printed">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a href="index.php"><img src="img/logo.png" style="width:150px;padding-left: 20px;padding-right:20px"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php if (!$_SESSION['id_customer']) { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Dossier
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="index.php">Planning de production</a></li
                                        <li><a class="dropdown-item" href="fabForm.php">Créer un dossier</a></li>
                                    </ul>
                                </li>
                                &nbsp&nbsp&nbsp&nbsp
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Tickets
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="tickets.php">Voir les tickets</a></li>
                                    </ul>
                                </li>
                                <?php if ($alert) { ?>
                                    <a href="tickets.php" class="material-icons" style="font-size: 30px;text-decoration: none;color: red;margin-top: 5px;">info</a></blink>
                                <?php } ?>  
                                &nbsp&nbsp&nbsp&nbsp
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Accueil client
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="reception.php">Créer</a></li>
                                        <li><a class="dropdown-item" href="receptionHistory.php">Historique</a></li>
                                    </ul>
                                </li>
                                &nbsp&nbsp&nbsp&nbsp
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Paramètres
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="arbo.php">Arborescence</a></li>
                                        <li><a class="dropdown-item" href="elements.php">Elements</a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                        <div style="color:black">
                            <a class="btn btn-danger" href="deconnexion.php">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>