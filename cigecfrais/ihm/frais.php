<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/searchbar.js"></script>
    <script src="scripts/dataExportCSV.js"></script>

    <h1>Liste des frais<br><br><br></h1>
    <!-- Menu dropdown pour filtrer les données du tableau -->
    <select id="searchDropdown1" onchange="trierTableDropdown(0, 2)" class="form-select form-select-lg mb-2">
        <option value="0" selected hidden>Filtrer par chantier</option>
        <option value="0">Ne pas filtrer</option>
        <?php 
            $les_chantiers = $bdd->recupChantiers();
            foreach($les_chantiers as $un_chantier) {
                echo "<option value=\"".$un_chantier["nom"]."\">".$un_chantier["nom"]."</option>";

            }
        ?>
    </select>
    <!-- Menu dropdown pour filtrer les données du tableau -->
    <select id="searchDropdown2" onchange="trierTableDropdown(0, 2)" class="form-select form-select-lg mb-2">
        <option value="0" selected hidden>Filtrer par type</option>
        <option value="0">Ne pas filtrer</option>
        <option value="Autoroute">Autoroute</option>
        <option value="Carburant">Carburant</option>
        <option value="Hotel">Hotel</option>
        <option value="Materiel">Materiel</option>
        <option value="Restauration">Restauration</option>
    </select>

    <button onclick="exportCSV()" class="btn btn-primary">Exporter en csv</button>

    <table id="tableRecherche" class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Chantier</th>
                <th scope="col">Fournisseur</th>
                <th scope="col">Type de frais</th>
                <th scope="col">Détails</th>
                <th scope="col">Date</th>
                <th scope="col">Prix</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Création de lignes dans le tableau pour chaque frais
                foreach($les_frais as $un_frais) {
                    //Remplissage du tableau avec les données
                    echo "<tr class=\"tr\">";
    
                    $chantier = $bdd->recupChantierAvecID($un_frais["chantierID"]);
                    echo "<td class=\"td\">".$chantier["nom"]."</td>";
    
                    echo "<td class=\"td\">".$un_frais["fournisseur"]."</td>";
                    
                    $fraisType = $bdd->recupFraisType($un_frais["fraisTypeID"]);
                    echo "<td class=\"td\">".$fraisType["type"]."</td>";

                    //Affiche des choses différentes dans la case détails
                    //pour chaque type de frais
                    if ($fraisType["type"] == "Materiel") {
                        echo "<td class=\"td\">/</td>";
                    } else {
                    echo "
                    <td class=\"td\">
                        <table class=\"table table-bordered table-sm\">
                            <tbody>
                                ";
                                if($fraisType["type"] == "Hotel") {
                                    echo "<tr><td>Nuits : ".$un_frais["nbNuits"]."</td></tr>";
                                    echo "<tr><td>Repas : ".$un_frais["nbRepas"]."</td></tr>";
                                }
                                if($fraisType["type"] == "Carburant" || $fraisType["type"] == "Autoroute") {
                                    echo "<tr><td>Compteur : ".$un_frais["compteur"]."</td></tr>";
                                    echo "<tr><td>Immatriculation : ".$un_frais["immatriculation"]."</td></tr>";
                                    
                                }
                                if($fraisType["type"] == "Restauration") {
                                    $nbPersonnes = $bdd->recupNbPersonnesAvecFraisID($un_frais["id"]);

                                    if ($nbPersonnes == 1) {
                                        echo "<tr><td>".$nbPersonnes." personne</td></tr>";
                                    } else {
                                        echo "<tr><td>".$nbPersonnes." personnes</td></tr>";
                                    }
                                }
                      echo "</tbody>
                        </table>
                    </td>";
                    } 
    
                    echo "<td class=\"td\">".$un_frais["date"]."</td>";
                    echo "<td class=\"td\">".$un_frais["prix"]."€</td>";
    
                    $lienPhoto = $bdd->recupLienPhotoAvecID($un_frais["photoID"]);
                    echo "<td class=\"td\"><a href=\"".$lienPhoto."\"><img src=\"assets/img/image-logo_x32.png\" alt=\"Accéder à la photo\"></a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>

<?php 
    include("pied-de-page.php")
?>
