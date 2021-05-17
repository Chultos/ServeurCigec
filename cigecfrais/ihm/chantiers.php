<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/searchbar.js"></script>

    <h1>Liste des chantiers <br><br><br></h1>
    <div class="input-group mb-2">
        <input type="text" class="form-control" id="searchInput" onkeyup="trierTable(1)" placeholder="Rechercher un chantier...">
    </div>
    <a href="/cigecfrais/?ihm=ajoutChantier">
        <button class="btn btn-primary">Ajouter un chantier</button>
    </a>

    <table id="tableRecherche" class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">N°</th>
                <th scope="col">Nom</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Création de lignes dans le tableau pour chaque chantier
                //Affiche en premier les chantiers "actifs"
                foreach($les_chantiers as $un_chantier) {
                    //Remplissage de la ligne avec les données
                    if($un_chantier["etat"] == "actif") {
                        echo "<tr class=\"table-success\">";
                        echo "<td>".$un_chantier["numeroID"]."</td>";
                        echo "<td>".$un_chantier["nom"]."</td>";

                        echo "<td>";
                            echo "<a href=\"/cigecfrais/?ihm=editionChantier&chantierID=".$un_chantier["id"]."\">";
                            echo "<button class=\"btn btn-dark\">Modifier</button></a>";
                            echo " ";
                            echo "<a href=\"/cigecfrais/?api=changerChantierEtat&chantierID=".$un_chantier["id"]."&chantierEtat=".$un_chantier["etat"]."\">";
                            echo "<button class=\"btn btn-danger\">X</button></a>";
                        echo "</td>";

                        echo "</tr>";
                    }
                }
                //Affiche les chantiers "inactifs"
                foreach($les_chantiers as $un_chantier) {
                    //Remplissage de la ligne avec les données
                    if($un_chantier["etat"] == "inactif") {
                        echo "<tr class=\"table-danger\">";
                        echo "<td>".$un_chantier["numeroID"]."</td>";
                        echo "<td>".$un_chantier["nom"]."</td>";

                        echo "<td>";
                        echo "<a href=\"/cigecfrais/?ihm=editionChantier&chantierID=".$un_chantier["id"]."\">";
                        echo "<button class=\"btn btn-dark\">Modifier</button></a>";
                        echo " ";
                        echo "<a href=\"/cigecfrais/?api=changerChantierEtat&chantierID=".$un_chantier["id"]."&chantierEtat=".$un_chantier["etat"]."\">";
                        echo "<button class=\"btn btn-success\">✓</button></a>";
                        echo "</td>";
                        
                        echo "</tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</body>

<?php 
    include("pied-de-page.php")
?>
