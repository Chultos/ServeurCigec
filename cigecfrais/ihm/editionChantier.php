<?php 
    include("en-tete.php")
?>

<body> 
    <?php
        echo "<h1>Edition du chantier ".$chantier["nom"]."<br><br><br></h1>";

        //Formulaire
        echo "<form action=\"index.php\" method=\"GET\">";
        echo    "<div class=\"form-group row\">";
        echo        "<div class=\"col\"></div>";
        echo        "<label class=\"col-sm-3 col-form-label\">Modifier le nom :</label>";
        echo        "<div class=\"col-sm-3\">";
        echo            "<input type=\"text\" name=\"nouveauNom\" class=\"form-control\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau nom...\" value=\"".$chantier["nom"]."\"required>";
        echo        "</div>";
        echo        "<div class=\"col\"></div><br><br>";
        echo    "</div>";
        
        echo    "<div class=\"form-group row\">";
        echo        "<div class=\"col\"></div>";
        echo        "<label class=\"col-sm-3 col-form-label\">Modifier le numéro :</label>";
        echo        "<div class=\"col-sm-3\">";
        echo            "<input type=\"text\" name=\"nouveauNumero\" class=\"form-control\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau numéro...\" value=\"".$chantier["numeroID"]."\"required>";
        echo        "</div>";
        echo        "<div class=\"col\"></div><br><br>";
        echo    "</div>";

        //Champs cachés pour transmettre l'action au controleur
        echo    "<input type=\"hidden\" name=\"chantierID\" value=\"".$chantierID."\" />";
        echo    "<input type=\"hidden\" name=\"action\" value=\"editionChantier\" />";

        echo    "<br>";
        //Bouton pour envoyer le formulaire
        echo    "<button type=\"submit\" class=\"btn btn-primary\">Sauvegarder les modifications</button>";
        echo "</form>";

        //Active le bouton supprimer si aucune donnée n'est liée au chantier
        if($chantierSupprimable == true) {
            echo " <a href=\"/cigecfrais/?action=supprimerChantier&chantierID=".$chantierID."\"><button class=\"btn btn-danger\">Supprimer le chantier</button></a>";
        } else {
            echo " <button class=\"btn btn-danger\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Des frais sont associés à ce chantier\" disabled>Supprimer le chantier</button>";
        }
    ?>
</body>

<?php 
    include("pied-de-page.php")
?>
