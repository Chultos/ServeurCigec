<?php 
    include("en-tete.php")
?>

<body> 
    <h1>Liste d'édition / suppression des chantiers <br><br><br></h1>
    <?php
        //Formulaire
        echo "<form action=\"index.php\" method=\"GET\">";
        echo    "<div class=\"form-group\">";
        echo        "<label>Modifier le nom :     </label>";
        echo        "<input type=\"text\" name=\"nouveauNom\" class=\"form-control\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau nom...\" value=\"".$chantier["nom"]."\">";
        echo        "<br><label>Modifier le numéro :</label>";
        echo        "<input type=\"text\" name=\"nouveauNumero\" class=\"form-control\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau numéro...\" value=\"".$chantier["numeroID"]."\">";
        echo    "</div>";

        //Champs cachés pour transmettre l'action au controleur
        echo    "<input type=\"hidden\" name=\"chantierID\" value=\"".$chantierID."\" />";
        echo    "<input type=\"hidden\" name=\"api\" value=\"editionChantier\" />";

        //Bouton pour envoyer le formulaire
        echo    "<button type=\"submit\" class=\"btn btn-primary\">Sauvegarder les modifications</button>";
        echo "</form>";

        //Active le bouton supprimer si aucune donnée n'est liée au chantier
        if($chantierSupprimable == true) {
            echo " <a href=\"/cigecfrais/?api=supprimerChantier&chantierID=".$chantierID."\"><button class=\"btn btn-danger\">Supprimer le chantier</button></a>";
        } else {
            echo " <button class=\"btn btn-danger\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Des frais sont associés à ce chantier\" disabled>Supprimer le chantier</button>";
        }
    ?>
</body>

<?php 
    include("pied-de-page.php")
?>
