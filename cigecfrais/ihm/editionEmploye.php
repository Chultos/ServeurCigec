<?php 
    include("en-tete.php")
?>

<body>
    <h1>Liste d'édition / suppression des employes <br><br><br></h1>
    <?php
        //Formulaire
        echo "<form action=\"index.php\" method=\"GET\">";
        echo    "<div class=\"form-group\">";
        echo        "<label>Modifier le nom :</label>";
        echo        "<input type=\"text\" name=\"nouveauNom\" class=\"form-control\" onkeyup=\"this.value = this.value.toUpperCase();\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau nom...\" value=\"".$employe["nom"]."\">";
        echo        "<label>Modifier le prénom :</label>";
        echo        "<input type=\"text\" name=\"nouveauPrenom\" class=\"form-control\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau nom...\" value=\"".$employe["prenom"]."\">";
        echo        "<br><label>Modifier le numéro de carte :</label>";
        echo        "<input type=\"text\" name=\"nouveauNumeroCarte\" class=\"form-control\" onfocus=\"this.select();\" placeholder=\"Entrer un nouveau numéro...\" value=\"".$employe["numeroCarte"]."\">";
        echo    "</div>";

        //Champs cachés pour transmettre l'action au controleur
        echo    "<input type=\"hidden\" name=\"employeID\" value=\"".$employeID."\" />";
        echo    "<input type=\"hidden\" name=\"api\" value=\"editionEmploye\" />";

        //Bouton pour envoyer le formulaire
        echo    "<button type=\"submit\" class=\"btn btn-primary\">Sauvegarder les modifications</button>";
        echo "</form>";

        //Active le bouton supprimer si aucune donnée n'est liée à l'employé
        if($employeSupprimable == true) {
            echo " <a href=\"/cigecfrais/?api=supprimerEmploye&employeID=".$employeID."\"><button class=\"btn btn-danger\">Supprimer l'employé</button></a>";
        } else {
            echo " <button class=\"btn btn-danger\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Des frais sont associés à cet employé\" disabled>Supprimer l'employé</button>";
        }
    ?>
</body>

<?php 
    include("pied-de-page.php")
?>
