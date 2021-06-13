<?php 
    include("en-tete.php")
?>

<body>
    <h1>Authentification<br><br><br></h1>
    <form action="?ihm=accueil" method="POST">
        <!-- Champs pour récupérer login et password -->
        <div class="form-group row">
            <div class="col"></div>

            <label class="col-sm-2 col-form-label">Identifiant :</label>
            <div class="col-sm-3">
                <input type="text" autocomplete="login" name="login" class="form-control" required>
            </div>

            <div class="col"></div>
            <br><br>
        </div>
        <div class="form-group row">
            <div class="col"></div>

            <label class="col-sm-2 col-form-label">Mot de passe :</label>
            <div class="col-sm-3">
                <input type="password" autocomplete="password" name="password" class="form-control" required>
            </div>

            <div class="col"></div>
        </div>

        <!-- Champ caché pour transmettre l'action au contrôleur -->
        <input type="hidden" name="action" value="authentification" />

        <br>
        <!-- Bouton pour envoyer le formulaire -->
        <button type="submit" class="btn btn-primary">S'authentifier</button>
    </form>
</body>

<?php 
    include("pied-de-page.php")
?>
