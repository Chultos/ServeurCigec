<?php 
    include("en-tete.php")
?>

<body>
    <h1>Ajout d'un employé<br><br><br></h1>

    <!-- Formulaire -->
    <form action="index.php" method="GET">
        <div class="form-group row">
            <div class="col"></div>
            <label class="col-sm-3 col-form-label">Nom :</label>
            <div class="col-sm-3">
                <input type="text" name="nom" onkeyup="this.value = this.value.toUpperCase();" class="form-control" placeholder="Entrer le nom..." required>
            </div>
            <div class="col"></div><br><br>
        </div>

        <div class="form-group row">
            <div class="col"></div>
            <label class="col-sm-3 col-form-label">Prenom :</label>
            <div class="col-sm-3">
                <input type="text" name="prenom" class="form-control" placeholder="Entrer le prénom..." required>
            </div>
            <div class="col"></div><br><br>
        </div>

        <div class="form-group row">
            <div class="col"></div>
            <label class="col-sm-3 col-form-label">Numéro de carte :</label>
            <div class="col-sm-3">
                <input type="text" name="numeroCarte" class="form-control" placeholder="Entrer le numéro de carte..." required>
            </div>
            <div class="col"></div><br><br>
        </div>

    <!-- Champ caché pour transmettre l'action au contrôleur -->
        <input type="hidden" name="action" value="ajoutEmploye" />

    <!-- Bouton pour envoyer le formulaire -->
        <button type="submit" class="btn btn-primary">Ajouter l'employé</button>
    </form>
</body>

<?php 
    include("pied-de-page.php")
?>
