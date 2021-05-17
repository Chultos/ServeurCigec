<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/editionChantier_getValue.js"></script>
    
    <h1>Ajout d'un employé <br><br><br></h1>
    <?php
        //Formulaire
        echo "<form action=\"index.php\" method=\"GET\">";
        echo    "<div class=\"form-group\">";
        echo        "<label>Nom : </label>";
        echo        "<input type=\"text\" name=\"nom\" onkeyup=\"this.value = this.value.toUpperCase();\" class=\"form-control\" placeholder=\"Entrer le nom...\">";
        echo        "<label>Prenom : </label>";
        echo        "<input type=\"text\" name=\"prenom\" class=\"form-control\" placeholder=\"Entrer le prénom...\">";
        echo        "<br><label>Numéro de carte : </label>";
        echo        "<input type=\"text\" name=\"numeroCarte\" class=\"form-control\" placeholder=\"Entrer le numéro de carte...\">";
        echo    "</div>";

        //Champ caché pour transmettre l'action au controleur
        echo    "<input type=\"hidden\" name=\"api\" value=\"ajoutEmploye\" />";

        //Bouton pour envoyer le formulaire
        echo    "<button type=\"submit\" class=\"btn btn-primary\">Ajouter l'employé</button>";
        echo "</form>";
    ?>
</body>

<?php 
    include("pied-de-page.php")
?>
