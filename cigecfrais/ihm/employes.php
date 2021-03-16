<?php 
    include("en-tete.php")
?>

<body>
    <script src="scripts/searchbar.js"></script>

    <h1>Liste des employés de l'entreprise <br><br><br></h1>
    <input type="text" id="searchInput" onkeyup="trierTable()" placeholder="Rechercher un employé...">
    <table id="tableEmployes" class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">NOM Prénom</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Création des lignes pour chaque employé
                foreach($les_employes as $un_employe) {
                    echo "<tr>";
                    echo "<td><a class=employeLink href=\"?ihm=fraisEmploye&employeID=".$un_employe["id"]."\"><button type=\"button\" class=\"btn btn-link\">".$un_employe["nom"]." ".$un_employe["prenom"]."</button></a></td>";
                    echo "<td><a href=\"/cigecfrais/?ihm=editionEmploye&employeID=".$un_employe["id"]."\">";
                    echo "<button class=\"btn btn-dark\">Editer</button></a>";
                    echo " ";
                    echo "<a href=\"/cigecfrais/?ihm=suppressionEmploye&employeID=".$un_employe["id"]."\">";
                    echo "<button class=\"btn btn-danger\">Supprimer</button></a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>

<?php 
    include("pied-de-page.php")
?>
