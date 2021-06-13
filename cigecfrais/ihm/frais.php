<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/trierTableau.js"></script>
    <script src="scripts/dataExportCSV.js"></script>
    <script src="scripts/filtreDropdown.js"></script>

    <h1>Liste des frais<br><br><br></h1>

    <!-- Bouton pour télécharger les données du tableau en fichier .csv -->
    <button onclick="exportCSV()" class="btn btn-success mb-2">Exporter en fichier excel</button><br>

    <div class="container">
        <div class="row">
            <div class="col">
                <!-- Menu dropdown pour filtrer les données du tableau -->
                <select id="filtreRechercheDropdown1" onchange="filtrageDropdownDansColonne(1, 1)" class="form-select form-select-lg mb-2 me-2 filtreRechercheDropdown">
                    <option value="0" selected hidden>Chantier...</option>
                    <option value="0">Ne pas filtrer</option>
                    <?php 
                        $les_chantiers = $bdd->recupChantiers();
                        foreach($les_chantiers as $un_chantier) {
                            echo "<option value=\"".$un_chantier["nom"]."\">".$un_chantier["nom"]."</option>";

                        }
                    ?>
                </select>
                <!-- Champ caché pour stocker le numéro des lignes enlevées par le filtre -->
                <input id="filtreCache1" class="filtreCache" type="hidden" value="">
            </div>

            <div class="col">
                <!-- Menu dropdown pour filtrer les données du tableau -->
                <select id="filtreRechercheDropdown2" onchange="filtrageDropdownDansColonne(2, 2)" class="form-select form-select-lg mb-2 me-2 filtreRechercheDropdown">
                    <option value="0" selected hidden>Fournisseur...</option>
                    <option value="0">Ne pas filtrer</option>
                    <?php 
                        $les_fournisseurs = $bdd->recupFournisseurs();
                        foreach($les_fournisseurs as $un_fournisseur) {
                            echo "<option value=\"".$un_fournisseur["fournisseur"]."\">".$un_fournisseur["fournisseur"]."</option>";

                        }
                    ?>
                </select>
                <!-- Champ caché pour stocker le numéro des lignes enlevées par le filtre -->
                <input id="filtreCache2" class="filtreCache" type="hidden" value="">
            </div>

            <div class="col">
                <!-- Menu dropdown pour filtrer les données du tableau -->
                <select id="filtreRechercheDropdown3" onchange="filtrageDropdownDansColonne(3, 3)" class="form-select form-select-lg mb-2 me-2 filtreRechercheDropdown">
                    <option value="0" selected hidden>Type de frais...</option>
                    <option value="0">Ne pas filtrer</option>
                    <option value="Autoroute">Autoroute</option>
                    <option value="Carburant">Carburant</option>
                    <option value="Hotel">Hotel</option>
                    <option value="Materiel">Materiel</option>
                    <option value="Restauration">Restauration</option>
                </select>
                <!-- Champ caché pour stocker le numéro des lignes enlevées par le filtre -->
                <input id="filtreCache3" class="filtreCache" type="hidden" value="">
            </div>
                    
            <div class="col">
                <!-- Champ de texte pour filtrer les données du tableau -->
                <div class="input-group mb-2">
                    <input type="text" class="form-control filtreRechercheTextInput" id="filtreRechercheTextInput4" onkeyup="filtrageTexteDansColonne(4,4)" placeholder="Date...">
                </div>

                <!-- Champ caché pour stocker le numéro des lignes enlevées par le filtre -->
                <input id="filtreCache4" class="filtreCache" type="hidden" value="">
            </div>
        </div>
    </div>

    <table id="tableRecherche" class="table table-hover" cellspacing="0">
        <thead class="table-dark">
            <tr>
                <th scope="col">Payeur</th>
                <th scope="col">Chantier</th>
                <th scope="col">Fournisseur</th>
                <th scope="col">Type de frais</th>
                <th scope="col">Détails</th>
                <th scope="col">Date</th>
                <th scope="col" class="clickableTHeader" onclick="trierTableau(4)">Prix</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Création de lignes dans le tableau pour chaque frais
                foreach($les_frais as $un_frais) {
                    //Remplissage du tableau avec les données
                    echo "<tr class=\"tr table-success\">";
                    $employePayeurID = $bdd->recupEmployePayeurIdAvecFraisID($un_frais["id"]);
                    $employePayeur = $bdd->recupEmployeAvecID($employePayeurID);
                    echo "<td class=\"td\"><a class=\"employeLink\" href=\"?ihm=fraisEmploye&employeID=".$employePayeurID."\">".$employePayeur["nom"]." ".$employePayeur["prenom"]."</a></td>";
    
                    $chantier = $bdd->recupChantierAvecID($un_frais["chantierID"]);
                    echo "<td class=\"td\">".$chantier["nom"]."</td>";
    
                    echo "<td class=\"td\">".$un_frais["fournisseur"]."</td>";
                    
                    $fraisType = $bdd->recupFraisType($un_frais["fraisTypeID"]);
                    echo "<td class=\"td\">".$fraisType["type"]."</td>";

                    //Affiche des choses différentes dans la case détails
                    //pour chaque type de frais
                    if ($fraisType["type"] == "Materiel") {
                        echo "<td>/</td>";
                    } else {
                    echo "
                    <td>
                        <table class=\"table table-modified table-bordered table-sm table-hover\" cellspacing=\"0\">
                            <tbody>
                                ";
                                if($fraisType["type"] == "Hotel") {
                                    echo "<tr class=\"table-success\"><td>Nuits : ".$un_frais["nbNuits"]."</td></tr>";
                                    echo "<tr class=\"table-success\"><td>Repas : ".$un_frais["nbRepas"]."</td></tr>";
                                }
                                if($fraisType["type"] == "Carburant" || $fraisType["type"] == "Autoroute") {
                                    echo "<tr class=\"table-success\"><td>Compteur : ".$un_frais["compteur"]."</td></tr>";
                                    echo "<tr class=\"table-success\"><td>Immatriculation : ".$un_frais["immatriculation"]."</td></tr>";
                                    
                                }
                                if($fraisType["type"] == "Restauration") {
                                    $nbPersonnes = $bdd->recupNbPersonnesAvecFraisID($un_frais["id"]);

                                    if ($nbPersonnes == 1) {
                                        echo "<tr class=\"table-success\"><td>/";
                                    } else {
                                        echo "<tr class=\"table-success\"><td>";
                                        echo    "<button class=\"btn btn-link-modified\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#restaurationCollapse".$un_frais["id"]."\" aria-expanded=\"false\" aria-controls=\"restaurationCollapse\">";
                                        echo        $nbPersonnes." personnes";
                                        echo    "</button>";
                                        $les_employesID_repas = $bdd->recupEmployesIdAvecFraisID($un_frais["id"]);
                                    
                                        echo "<div class=\"collapse\" id=\"restaurationCollapse".$un_frais["id"]."\"><p><br>";
                                        foreach($les_employesID_repas as $une_employeID_repas) {
                                            $employe_repas = $bdd->recupEmployeAvecID($une_employeID_repas["employeID"]);

                                            echo $employe_repas["nom"]." ".$employe_repas["prenom"]."<br>";
                                        }
                                        echo "</p></div>";
                                    }
                                    echo "</td></tr>";
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
