<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/searchbar.js"></script>

    <h1>Liste des employés de l'entreprise <br><br><br></h1>

    <div class="input-group mb-2">
        <input type="text" class="form-control" id="searchInput" onkeyup="trierTable(0)" placeholder="Rechercher un employé...">
    </div>
    <a href="/cigecfrais/?ihm=ajoutEmploye">
        <button class="btn btn-primary">Ajouter un employé</button>
    </a>

    <table id="tableRecherche" class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">NOM Prénom</th>
                <th scope="col">N° Carte</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Création de lignes dans le tableau pour chaque employé
                //Affiche en premier les employés "actifs"
                foreach($les_employes as $un_employe) {
                    //Remplissage de la ligne avec les données
                    if($un_employe["etat"] == "actif") {
                        echo "<tr class=\"table table-success\">";
                        echo "<td><a class=employeLink href=\"?ihm=fraisEmploye&employeID=".$un_employe["id"]."\"><button type=\"button\" class=\"btn btn-link\">".$un_employe["nom"]." ".$un_employe["prenom"]."</button></a></td>";
                        echo "<td>".$un_employe["numeroCarte"]."</td>";

                        echo "<td><a href=\"/cigecfrais/?ihm=editionEmploye&employeID=".$un_employe["id"]."\">";
                        echo "<button class=\"btn btn-dark\">Modifier</button></a>";
                        echo " ";
                        echo "<a href=\"/cigecfrais/?api=changerEmployeEtat&employeID=".$un_employe["id"]."&employeEtat=".$un_employe["etat"]."\">";
                        echo "<button class=\"btn btn-danger\">X</button></a></td>";

                        echo "</tr>";
                    }
                }
                //Affiche les employés "inactifs"
                foreach($les_employes as $un_employe) {
                    //Remplissage de la ligne avec les données
                    if($un_employe["etat"] == "inactif") {
                        echo "<tr class=\"table table-danger\">";
                        echo "<td><a class=employeLink href=\"?ihm=fraisEmploye&employeID=".$un_employe["id"]."\"><button type=\"button\" class=\"btn btn-link\">".$un_employe["nom"]." ".$un_employe["prenom"]."</button></a></td>";
                        echo "<td>".$un_employe["numeroCarte"]."</td>";

                        echo "<td><a href=\"/cigecfrais/?ihm=editionEmploye&employeID=".$un_employe["id"]."\">";
                        echo "<button class=\"btn btn-dark\">Modifier</button></a>";
                        echo " ";
                        echo "<a href=\"/cigecfrais/?api=changerEmployeEtat&employeID=".$un_employe["id"]."&employeEtat=".$un_employe["etat"]."\">";
                        echo "<button class=\"btn btn-success\">✓</button></a></td>";
                        
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
