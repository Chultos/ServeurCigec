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
                <th scope="col">#</th>
                <th scope="col">NOM Prénom</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Création des lignes pour chaque employé
                foreach($les_employes as $un_employe) {
                    echo "<tr>";
                    echo "<th scope=\"row\">".$un_employe["id"]."</th>";
                    echo "<td>".$un_employe["nom"]." ".$un_employe["prenom"]."</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>

<?php 
    include("pied-de-page.php")
?>
