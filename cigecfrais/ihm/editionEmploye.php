<?php 
    include("en-tete.php")
?>

<body>
    <?php
        echo "<h1>Edition de ".$employe["nom"]." ".$employe["prenom"]."<br><br><br></h1>";

        //Formulaire
        echo "<form action=\"index.php\" method=\"GET\">";
        echo    "<div class=\"form-group row\">";
        echo        "<div class=\"col\"></div>";
        echo        "<label class=\"col-sm-3 col-form-label\">Modifier le nom :</label>";
        echo        "<div class=\"col-sm-3\">";
        echo            "<input type=\"text\" name=\"nouveauNom\" class=\"form-control\" onkeyup=\"this.value = this.value.toUpperCase();\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau nom...\" value=\"".$employe["nom"]."\"required>";
        echo        "</div>";
        echo        "<div class=\"col\"></div><br><br>";
        echo    "</div>";

        echo    "<div class=\"form-group row\">";
        echo        "<div class=\"col\"></div>";
        echo        "<label class=\"col-sm-3 col-form-label\">Modifier le prénom :</label>";
        echo        "<div class=\"col-sm-3\">";
        echo            "<input type=\"text\" name=\"nouveauPrenom\" class=\"form-control\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau nom...\" value=\"".$employe["prenom"]."\"required>";
        echo        "</div>";
        echo        "<div class=\"col\"></div><br><br>";
        echo    "</div>";

        echo    "<div class=\"form-group row\">";
        echo        "<div class=\"col\"></div>";
        echo        "<label class=\"col-sm-3 col-form-label\">Modifier le numéro de carte :</label>";
        echo        "<div class=\"col-sm-3\">";
        echo            "<input type=\"text\" name=\"nouveauNumeroCarte\" class=\"form-control\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau numéro...\" value=\"".$employe["numeroCarte"]."\"required>";
        echo        "</div>";
        echo        "<div class=\"col\"></div><br><br>";
        echo    "</div>";

        //Champs cachés pour transmettre l'action au controleur
        echo    "<input type=\"hidden\" name=\"employeID\" value=\"".$employeID."\" />";
        echo    "<input type=\"hidden\" name=\"action\" value=\"editionEmploye\" />";

        echo    "<br>";
        //Bouton pour envoyer le formulaire
        echo    "<button type=\"submit\" class=\"btn btn-primary\">Sauvegarder les modifications</button>";
        echo "</form>";

        //Active le bouton supprimer si aucune donnée n'est liée à l'employé
        if($employeSupprimable == true) {
            echo " <a href=\"/cigecfrais/?action=supprimerEmploye&employeID=".$employeID."\"><button class=\"btn btn-danger\">Supprimer l'employé</button></a>";
        } else {
            echo " <button class=\"btn btn-danger\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Des frais sont associés à cet employé\" disabled>Supprimer l'employé</button>";
        }
    ?>
</body>

<?php 
    include("pied-de-page.php")
?>
