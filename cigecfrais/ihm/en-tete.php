<?php
/**
 * Cigec Frais (En-tete)
 * @author Teva Petorin
 */
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cigec Frais</title>
    <link rel="icon" href="assets/logo-cigecx32.png">

    <!-- Lien externe vers le CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Styles CSS complémentaires -->
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        body {
            padding-top: 5rem;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Barre de navigation avec le menu -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

        <!-- Le titre -->
        <a class="navbar-brand" href="/cigecfrais/?ihm=accueil">
            <img src="assets/logo-entete.png" alt="Logo de l'entreprise" width="40.5" height="48,9">
            Frais
        </a>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if($_GET["ihm"] == "employes") {echo " active";}?>">
                    <a class="nav-link" href="/cigecfrais/?ihm=employes">Employés</a>
                </li>
                <li class="nav-item <?php if($_GET["ihm"] == "chantiers") {echo " active";}?>">
                    <a class="nav-link" href="/cigecfrais/?ihm=chantiers">Chantiers</a>
                </li>
                <li class="nav-item <?php if($_GET["ihm"] == "evolution") {echo " active";}?>">
                    <a class="nav-link" href="/cigecfrais/?ihm=evolution">Evolution</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteneur principal de l'application web -->
    <main role="main" class="container">
        <div class="starter-template">
