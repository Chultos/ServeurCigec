<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/trierTableau.js"></script>

    <?php 
        echo "<p>Page des frais de ".$employe["nom"]." ".$employe["prenom"]."</p>";
    ?>
    <!-- Création du tableau avec possibilité de cliquer sur le colonnes pour trier les données -->
    <table id="sorTable" class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th class="clickableTHeader" onclick="sortTable(0)" scope="col">Chantier</th>
                <th class="clickableTHeader" onclick="sortTable(1)" scope="col">Fournisseur</th>
                <th class="clickableTHeader" onclick="sortTable(2)" scope="col">Type de frais</th>
                <th class="clickableTHeader" onclick="sortTable(3)" scope="col">Date</th>
                <th class="clickableTHeader" onclick="sortTable(4)" scope="col">Prix</th>
                <th class="clickableTHeader" onclick="sortTable(5)" scope="col">A payé ?</th>
                <th class="clickableTHeader" onclick="sortTable(6)" scope="col">Carte</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
        <?php
            //Création de lignes dans le tableau pour chaque Paiement
            foreach($les_paiements as $paiement) {
                //Remplissage du tableau
                $frais = $bdd->recupFraisAvecID($paiement["fraisID"]);
                echo "<tr>";

                $chantier = $bdd->recupChantierAvecID($frais["chantierID"]);
                echo "<td>".$chantier["nom"]."</td>";

                echo "<td>".$frais["fournisseur"]."</td>";
                
                $fraisType = $bdd->recupFraisType($frais["fraisTypeID"]);
                echo "<td>".$fraisType["type"]."</td>";

                echo "<td>".$frais["date"]."</td>";
                echo "<td>".$frais["prix"]."€</td>";

                if($paiement["payeur"] == "true") {
                    echo "<td>Oui</td>";
                } else if($paiement["payeur"] == "false") {
                    echo "<td>Non</td>";
                } else {
                    echo "<td>?</td>";
                }

                echo "<td>".$paiement["typeCarte"]."</td>";

                $lienPhoto = $bdd->recupLienPhotoAvecID($frais["photoID"]);
                echo "<td><a href=\"".$lienPhoto."\"><img src=\"assets/img/image-logo_x32.png\" alt=\"Accéder à la photo\"></a></td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    
</body>

<?php 
    include("pied-de-page.php")
?>
