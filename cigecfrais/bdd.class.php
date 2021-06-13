<?php
/**
* Classe pour accéder à une base de données SQLite3
*/
class Bdd {

    // DSN : Data Source Name pour accéder à la base de données SQLite3
    private $dsn = "";

    // Gestionnaire de base de données (database handler)
    private $dbh = NULL;

    /**
    * Méthode constructeur de la classe chargé d'initialiser PDO
    */
    public function __construct($CHEMIN_BDD) {
        // Préparation du dsn
        $this->dsn = "sqlite:".$CHEMIN_BDD;

        // Instanciation d'un objet PDO (PHP Database Object)
        $this->dbh = new PDO($this->dsn);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //Fonction qui permet l'ajout de frais dans la base de données
    public function ajouterFrais($nbPersonnes, $lienPhoto, $prix, $fournisseur, $date, $nbRepas, $nbNuits, $immatriculation, $compteur, $chantierID, $fraisTypeID, $typeCarte) {
        //Sauvegarde du lien de la photo
        $this->saveLienPhoto($lienPhoto);

        //Récupération de l'id de la photo
        $photoID = $this->getPhotoID($lienPhoto);

        //Sauvegarde de la note de frais
        $this->saveFrais($prix, $fournisseur, $date, $nbRepas, $nbNuits, $immatriculation, $compteur, $photoID, $chantierID, $fraisTypeID);

        //Récupération de l'id du frais
        $fraisID = $this->getFraisID($prix, $fournisseur, $date);

        //Sauvegarde des données de paiement
        for ($i=0; $i < $nbPersonnes; $i++) {
            $employeID = $_GET[$i."employeID"];
            $payeur = $_GET[$i."payeur"];

            //Permet de vérifier le type de carte utilisé si l'employé est payeur
            if($payeur == "true") {
                $typeCarte = $_GET["typeCarte"];
            } else {
                $typeCarte = "  /  ";
            }

            //Sauvegarde des données
            $this->savePaiement($fraisID, $employeID, $payeur, $typeCarte);
        }
    }

    //Fonction qui sauvegarde le lien de la photo dans la base de données
    public function saveLienPhoto($lienPhoto) {
        // Préparation de la requête SQL
        $requete_sql = "INSERT INTO Photos(lien) VALUES ( ? )";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute(array($lienPhoto));
        return $resultats;
    }

    //Fonction qui récupère l'id d'une photo grâce à son lien
    public function getPhotoID($lienPhoto) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT id FROM Photos WHERE lien=?";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL et récupération de l'id
        $stmt->execute(array($lienPhoto));
        $resultats = $stmt->fetch();
        return $resultats[0];
    }

    //Fonction qui sauvegarde les frais dans la base de données
    public function saveFrais($prix, $fournisseur, $date, $nbRepas, $nbNuits, $immatriculation, $compteur, $photoID, $chantierID, $fraisTypeID) {
        // Préparation de la requête SQL
        $requete_sql = "INSERT INTO Frais(prix, fournisseur, date, nbRepas, nbNuits, immatriculation, compteur, photoID, chantierID, fraisTypeID) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute(array ($prix, $fournisseur, $date, $nbRepas, $nbNuits, $immatriculation, $compteur, $photoID, $chantierID, $fraisTypeID));
        return $resultats;
    }

    //Fonction qui récupère l'id d'un frais grace a certaines données
    public function getFraisID($prix, $fournisseur, $date) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT id FROM Frais WHERE prix=? AND fournisseur=? AND date=?";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL et récupération de l'id
        $stmt->execute(array($prix, $fournisseur, $date));
        $resultats = $stmt->fetch();
        return $resultats[0];
    }

    //Fonction qui sauvegarde les paiements dans la base de données
    public function savePaiement($fraisID, $employeID, $payeur, $typeCarte) {
        // Préparation de la requête SQL
        $requete_sql = "INSERT INTO Paiements(fraisID, employeID, payeur, typeCarte) VALUES ( ?, ?, ?, ? )";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute(array($fraisID, $employeID, $payeur, $typeCarte));
        return $resultats;
    }

    //Fonction qui récupère tous les employés dans la base de donnée
	public function recupEmployes() {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Employes ORDER BY nom ASC";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    }

    //Fonction qui récupère les données d'un employé grâce à son id
    public function recupEmployeAvecID($employeID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Employes WHERE id=$employeID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats;
    }

    //Fonction qui récupère les données de l'employé payeur grâce à l'id d'un frais
    public function recupEmployePayeurIdAvecFraisID($fraisID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT employeID FROM Paiements WHERE fraisID=$fraisID AND payeur=\"true\"";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats["employeID"];
    }

    //Fonction qui récupère l'ID de plusieurs employés grâce à l'id d'un frais
    public function recupEmployesIdAvecFraisID($fraisID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT employeID FROM Paiements WHERE fraisID=$fraisID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    }

    //Fonction qui récupère les paiements d'un employé grâce à son id
    public function recupPaiementsEmploye($employeID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Paiements, Frais WHERE employeID=$employeID AND fraisID = Frais.id ORDER BY date DESC";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetchAll();
        return $resultats;
    }

    //Fonction qui récupère un frais avec son id
    public function recupFraisAvecID($fraisID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Frais WHERE id=$fraisID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats;
    }

    //Fonction qui récupère le nom d'un type de frais avec son id
    public function recupFraisType($fraisTypeID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM FraisType WHERE id=$fraisTypeID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats;
    }

    //Fonction qui récupère les données d'un chantier avec son id
    public function recupChantierAvecID($chantierID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Chantiers WHERE id=$chantierID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats;
    }

    //Fonction qui récupère le lien d'une photo avec son id
    public function recupLienPhotoAvecID($photoID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Photos WHERE id=$photoID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats["lien"];
    }

    //Fonction qui récupère tout les chantiers
    public function recupChantiers() {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Chantiers ORDER BY nom ASC";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    }

    //Fonction qui récupère tout les chantiers
    public function recupFournisseurs() {
        // Préparation de la requête SQL
        $requete_sql = "SELECT fournisseur FROM Frais ORDER BY fournisseur ASC";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    }

    //Fonction qui récupère l'id d'un chantier avec son nom
    public function recupChantierIDAvecNom($nomChantier) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT id FROM Chantiers WHERE nom=\"$nomChantier\"";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats["id"];
    }

    //Fonction qui récupère l'id d'un type de frais avec son nom
    public function recupFraisTypeIDAvecNom($nomFraisType) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT id FROM FraisType WHERE type=\"$nomFraisType\"";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats["id"];
    }

    //Fonction qui permet de changer l'état (actif/inactif) d'un chantier
    public function changerChantierEtat($chantierID, $chantierEtat) {
        // Préparation de la requête SQL
        if($chantierEtat == "actif") {
            $requete_sql = "UPDATE Chantiers SET etat=\"inactif\" WHERE id=$chantierID";
        } else {
            $requete_sql = "UPDATE Chantiers SET etat=\"actif\" WHERE id=$chantierID";
        }
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();
        return $resultats;
    }

    //Fonction qui permet d'éditer un chantier
    public function editerChantier($chantierID, $nom, $numeroID) {
        // Préparation de la requête SQL
        $requete_sql = "UPDATE Chantiers SET nom=\"$nom\", numeroID=$numeroID WHERE id=$chantierID";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();
        return $resultats;
    }

    //Fonction qui détermine si un chantier peut être supprimé
    public function chantierSupprimable($chantierID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT COUNT(id) FROM Frais WHERE chantierID=$chantierID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetchAll();
        if($resultats[0]["COUNT(id)"] == 0) {
            return true;
        } else {
            return false;
        }
    }

    //Fonction qui supprime un chantier
    public function supprimerChantier($chantierID) {
        // Préparation de la requête SQL
        $requete_sql = "DELETE FROM Chantiers WHERE id=$chantierID";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();
        return $resultats;
    }

    //Fonction qui ajoute un chantier
    public function ajouterChantier($nom, $numeroID) {
        // Préparation de la requête SQL
        $requete_sql = "INSERT INTO Chantiers(nom, numeroID, etat) VALUES (\"$nom\", $numeroID, \"actif\")";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();
        return $resultats;
    }

    //Fonction qui ajoute un employe
    public function ajouterEmploye($nom, $prenom, $numeroCarte) {
        // Préparation de la requête SQL
        $requete_sql = "INSERT INTO Employes(nom, prenom, numeroCarte, etat) VALUES (\"$nom\", \"$prenom\", \"$numeroCarte\", \"actif\")";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();
        return $resultats;
    }

    //Fonction qui permet de changer l'état (actif/inactif) d'un employé
    public function changerEmployeEtat($employeID, $employeEtat) {
        // Préparation de la requête SQL
        if($employeEtat == "actif") {
            $requete_sql = "UPDATE Employes SET etat=\"inactif\" WHERE id=$employeID";
        } else {
            $requete_sql = "UPDATE Employes SET etat=\"actif\" WHERE id=$employeID";
        }
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();
        return $resultats;
    }

    //Fonction qui détermine si un employé est supprimable
    public function employeSupprimable($employeID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT COUNT(id) FROM Paiements WHERE employeID=$employeID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetchAll();
        if($resultats[0]["COUNT(id)"] == 0) {
            return true;
        } else {
            return false;
        }
    }

    //Fonction qui édite un employé
    public function editerEmploye($employeID, $nom, $prenom, $numeroCarte) {
        // Préparation de la requête SQL
        $requete_sql = "UPDATE Employes SET nom=\"$nom\", prenom=\"$prenom\", numeroCarte=\"$numeroCarte\" WHERE id=$employeID";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();
        return $resultats;
    }

    //Fonction qui supprime un employé
    public function supprimerEmploye($employeID) {
        // Préparation de la requête SQL
        $requete_sql = "DELETE FROM Employes WHERE id=$employeID";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();
        return $resultats;
    }

    //Fonction qui récupère les frais, des filtres supplémentaires peuvent etre utilisés 
    public function recupFrais() {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Frais ORDER BY date DESC";

		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    }

    //Fonction qui récupère le nombre de personne d'un frais avec son ID (ex: repas pour 5 personnes)
    public function recupNbPersonnesAvecFraisID($fraisID) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT COUNT(fraisID) FROM Paiements WHERE fraisID=$fraisID";
		$stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute();

		// Récupération des résultats
		$resultats = $stmt->fetch();
        return $resultats[0];
    }
}