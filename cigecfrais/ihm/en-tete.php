<?php
    /**
    * Cigec Frais (En-tete)
    * @author Teva Petorin
    * @date 30/05/2021
    * @version 0.5 (beta)
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

    <!-- Lien externe jQuery -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    
    <!-- Lien externe vers le JS -->
    <script src="assets/js/bootstrap.js"></script>

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
            text-decoration: none;
            font-weight: bold;
        }
        .employeLink:visited {
            color: #212529;
            text-decoration: none;
        }
        .employeLink:hover {
            color: #212529;
            text-decoration: underline;
        }
        .employeLink {
            color: #212529;
        }
        .btn-link-modified {
            color: #212529;
        }
        .btn-link-modified:hover {
            color: #212529;
            text-decoration: underline;
            font-weight: bold;
        }
        .btn-link-modified:disabled, .btn-link-modified.disabled {
            color: #212529;
        }
        .clickableTHeader:hover {
            cursor: pointer;
            text-decoration: underline;
        }
        .form-select {
            display: inline-block;
            width: 100%;
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
        table {
            caption-side: bottom;
            border-collapse: separate;
        }
    </style>
</head>

<body>
    <!-- Barre de navigation avec des menus -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

        <!-- Le titre -->
        <a class="navbar-brand ms-2" href="/cigecfrais/?ihm=accueil">
            <img src="assets/img/logo-cigecfrais.png" alt="Logo du site web" width="50" height="50">
        </a>

        <!-- Les menus -->
        <?php
            if ((isset($_SESSION["authentification"]) == TRUE) || ($_SESSION["authentification"] != 0)) {
                echo "<div class=\"collapse navbar-collapse\" id=\"navbarsExampleDefault\">
                    <ul class=\"navbar-nav mr-auto\">
                        <li class=\"nav-item\">
                            <a class=\"nav-link "; if($_GET["ihm"] == "employes") {echo " active";} echo "\" href=\"/cigecfrais/?ihm=employes\">Employés</a>
                        </li>
                        <li class=\"nav-item\">
                            <a class=\"nav-link "; if($_GET["ihm"] == "chantiers") {echo " active";} echo "\" href=\"/cigecfrais/?ihm=chantiers\">Chantiers</a>
                        </li>
                        <li class=\"nav-item\">
                            <a class=\"nav-link "; if($_GET["ihm"] == "frais") {echo " active";} echo "\" href=\"/cigecfrais/?ihm=frais\">Frais</a>
                        </li>
                        <li class=\"nav-item\">
                            <a class=\"nav-link "; if($_GET["ihm"] == "recapitulatif") {echo " active";} echo "\" href=\"/cigecfrais/?ihm=recapitulatif\">Récapitulatif</a>
                        </li>
                    </ul>
                </div>";
                echo "<form class=\"form-inline\" action=\"index.php\" method=\"POST\">
                        <!-- Champ caché pour transmettre l'action au contrôleur -->
                        <input type=\"hidden\" name=\"action\" value=\"deconnexion\" />

                        <!-- Bouton pour envoyer le formulaire -->
                        <button class=\"btn btn-danger my-2 me-2 my-sm-0\" type=\"submit\">Déconnexion</button>
                    </form>";
            }
        ?>
        
    </nav>

    <!-- Conteneur principal de l'application web -->
    <main role="main" class="container">
        <div class="starter-template">
