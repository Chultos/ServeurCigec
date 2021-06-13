<?php 
    include("en-tete.php")
?>

<body>
    <h1>Ajout d'un chantier<br><br><br></h1>

    <!-- Formulaire -->
    <form action="index.php" method="GET">
        <div class="form-group row">
            <div class="col"></div>
            <label class="col-sm-3 col-form-label">Nom du chantier :</label>
            <div class="col-sm-3">
                <input type="text" name="nom" class="form-control" placeholder="Entrer un nom..." required>
            </div>
            <div class="col"></div><br><br>
        </div>

        <div class="form-group row">
            <div class="col"></div>
            <label class="col-sm-3 col-form-label">Numéro du chantier :</label>
            <div class="col-sm-3">
                <input type="text" name="numeroID" class="form-control" placeholder="Entrer un numéro..." required>
            </div>
            <div class="col"></div><br><br>
        </div>

    <!-- Champ caché pour transmettre l'action au contrôleur -->
        <input type="hidden" name="action" value="ajoutChantier" />

    <!-- Bouton pour envoyer le formulaire -->
        <button type="submit" class="btn btn-primary">Ajouter le chantier</button>
    </form>
</body>

<?php 
    include("pied-de-page.php")
?>
