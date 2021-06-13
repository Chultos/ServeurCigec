<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/trierTableau.js"></script>
    <script src="scripts/dataExportCSV.js"></script>
    <script src="scripts/filtreDropdown.js"></script>

    <?php 
        echo "<h1>Liste des frais de ".$employe["nom"]." ".$employe["prenom"]."<br><br><br></h1>";
    ?>

    <!-- Bouton pour télécharger les données du tableau en fichier .csv -->
    <?php
        echo "<button onclick=\"exportCSV('".$employe["nom"]."', '".$employe["prenom"]."')\" class=\"btn btn-success mb-2\">Exporter en fichier excel</button><br>";
    ?>

    <div class="container">
        <div class="row">
            <div class="col">
                <!-- Menu dropdown pour filtrer les données du tableau -->
                <select id="filtreRechercheDropdown1" onchange="filtrageDropdownDansColonne(0, 1)" class="form-select form-select-lg mb-2 me-2 filtreRechercheDropdown">
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
                <select id="filtreRechercheDropdown2" onchange="filtrageDropdownDansColonne(1, 2)" class="form-select form-select-lg mb-2 me-2 filtreRechercheDropdown">
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
                <select id="filtreRechercheDropdown3" onchange="filtrageDropdownDansColonne(2, 3)" class="form-select form-select-lg mb-2 me-2 filtreRechercheDropdown">
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
                    <input type="text" class="form-control filtreRechercheTextInput" id="filtreRechercheTextInput4" onkeyup="filtrageTexteDansColonne(3,4)" placeholder="Date...">
                </div>

                <!-- Champ caché pour stocker le numéro des lignes enlevées par le filtre -->
                <input id="filtreCache4" class="filtreCache" type="hidden" value="">
            </div>

            <div class="col">
            <!-- Menu dropdown pour filtrer les données du tableau -->
            <select id="filtreRechercheDropdown5" onchange="filtrageDropdownDansColonne(6, 5)" class="form-select form-select-lg mb-2 me-2 filtreRechercheDropdown">
                    <option value="0" selected hidden>Type de carte...</option>
                    <option value="0">Ne pas filtrer</option>
                    <option value="Personnelle">Personnelle</option>
                    <option value="Entreprise">Entreprise</option>
                    <option value="/">Pas de carte</option>
                </select>
                <!-- Champ caché pour stocker le numéro des lignes enlevées par le filtre -->
                <input id="filtreCache5" class="filtreCache" type="hidden" value="">
            </div>
        </div>
    </div>

    <!-- Création du tableau avec possibilité de cliquer certaines colonnes pour trier les données -->
    <table id="tableRecherche" class="table table-hover" cellspacing="0">
        <thead class="table-dark">
            <tr>
                <th scope="col">Chantier</th>
                <th scope="col">Fournisseur</th>
                <th scope="col">Type de frais</th>
                <th scope="col">Date</th>
                <th class="clickableTHeader" onclick="trierTableau(4)" scope="col">Prix</th>
                <th class="clickableTHeader" onclick="trierTableau(5)" scope="col">A payé ?</th>
                <th  scope="col">Carte</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
        <?php
            //Création de lignes dans le tableau pour chaque Paiement
            foreach($les_paiements as $paiement) {
                //Remplissage du tableau
                $frais = $bdd->recupFraisAvecID($paiement["fraisID"]);
                echo "<tr class=\"tr table-success\">";

                $chantier = $bdd->recupChantierAvecID($frais["chantierID"]);
                echo "<td class=\"td\">".$chantier["nom"]."</td>";

                echo "<td class=\"td\">".$frais["fournisseur"]."</td>";
                
                $fraisType = $bdd->recupFraisType($frais["fraisTypeID"]);
                echo "<td class=\"td\">".$fraisType["type"]."</td>";

                echo "<td class=\"td\">".$frais["date"]."</td>";
                echo "<td class=\"td\">".$frais["prix"]."€</td>";

                if($paiement["payeur"] == "true") {
                    echo "<td class=\"td\">Oui</td>";
                } else if($paiement["payeur"] == "false") {
                    echo "<td class=\"td\">Non</td>";
                } else {
                    echo "<td class=\"td\">?</td>";
                }

                echo "<td class=\"td\">".$paiement["typeCarte"]."</td>";

                $lienPhoto = $bdd->recupLienPhotoAvecID($frais["photoID"]);
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
