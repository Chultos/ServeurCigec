<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/editionChantier_getValue.js"></script>
    
    <h1>Ajout de chantier <br><br><br></h1>
    <?php
        //Formulaire
        echo "<form action=\"index.php\" method=\"GET\">";
        echo    "<div class=\"form-group\">";
        echo        "<label>Nom du chantier : </label>";
        echo        "<input type=\"text\" name=\"nom\" class=\"form-control\" placeholder=\"Entrer un nom...\">";
        echo        "<br><label>Numéro du chantier : </label>";
        echo        "<input type=\"text\" name=\"numeroID\" class=\"form-control\" placeholder=\"Entrer un numéro...\">";
        echo    "</div>";

        //Champ caché pour transmettre l'action au controleur
        echo    "<input type=\"hidden\" name=\"api\" value=\"ajoutChantier\" />";

        //Bouton pour envoyer le formulaire
        echo    "<button type=\"submit\" class=\"btn btn-primary\">Ajouter le chantier</button>";
        echo "</form>";
    ?>
</body>

<?php 
    include("pied-de-page.php")
?>
