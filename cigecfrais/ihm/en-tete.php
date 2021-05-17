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
    <link rel="icon" href="assets/img/logo-cigecfrais_x32.png">

    <!-- Lien externe vers le CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <!-- Lien externe vers le JS -->
    <link rel="javascript" href="assets/js/bootstrap.js">

    <!-- Lien externe jQuery -->
    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>

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
        .employeLink:link {
            color: #212529;
        }
        .employeLink:visited {
            color: #212529;
        }
        .employeLink:hover {
            color: #212529;
            font-weight: bold;
        }
        .clickableTHeader {
            cursor: pointer;
        }
        .form-select {
            display: inline-block;
            width: 25%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .form-select:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .form-select[multiple], .form-select[size]:not([size="1"]) {
            padding-right: 0.75rem;
            background-image: none;
        }
        .form-select:disabled {
            background-color: #e9ecef;
        }
        .form-select:-moz-focusring {
            color: transparent;
            text-shadow: 0 0 0 #212529;
        }
    </style>
</head>

<body>
    <!-- Barre de navigation avec le menu -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

        <!-- Le titre -->
        <a class="navbar-brand" href="/cigecfrais/?ihm=accueil">
            <img src="assets/img/logo-cigecfrais.png" alt="Logo du site web" width="50" height="50">
        </a>

        <!-- Les menus -->
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if($_GET["ihm"] == "employes") {echo " active";}?>">
                    <a class="nav-link" href="/cigecfrais/?ihm=employes">Employés</a>
                </li>
                <li class="nav-item <?php if($_GET["ihm"] == "chantiers") {echo " active";}?>">
                    <a class="nav-link" href="/cigecfrais/?ihm=chantiers">Chantiers</a>
                </li>
                <li class="nav-item <?php if($_GET["ihm"] == "frais") {echo " active";}?>">
                    <a class="nav-link" href="/cigecfrais/?ihm=frais">Frais</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteneur principal de l'application web -->
    <main role="main" class="container">
        <div class="starter-template">
