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

    public function saveLienPhoto($lienPhoto) {
        // Préparation de la requête SQL
        $requete_sql = "INSERT INTO Photos(lien) VALUES ( ? )";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute(array($lienPhoto));
        return $resultats;
    }

    public function getPhotoID($lienPhoto) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT id FROM Photos WHERE lien=?";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL et récupération de l'id
        $stmt->execute(array($lienPhoto));
        $resultats = $stmt->fetch();
        return $resultats[0];
    }

    public function saveFrais($prix, $fournisseur, $date, $nbRepas, $nbNuits, $immatriculation, $compteur, $photoID, $chantierID, $fraisTypeID) {
        // Préparation de la requête SQL
        $requete_sql = "INSERT INTO Frais(prix, fournisseur, date, nbRepas, nbNuits, immatriculation, compteur, photoID, chantierID, fraisTypeID) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute(array ($prix, $fournisseur, $date, $nbRepas, $nbNuits, $immatriculation, $compteur, $photoID, $chantierID, $fraisTypeID));
        return $resultats;
    }

    public function getFraisID($prix, $fournisseur, $date) {
        // Préparation de la requête SQL
        $requete_sql = "SELECT id FROM Frais WHERE prix=? AND fournisseur=? AND date=?";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL et récupération de l'id
        $stmt->execute(array($prix, $fournisseur, $date));
        $resultats = $stmt->fetch();
        return $resultats[0];
    }

    public function savePaiement($fraisID, $employeID, $payeur, $typeCarte) {
        // Préparation de la requête SQL
        $requete_sql = "INSERT INTO Paiement(fraisID, employeID, payeur, typeCarte) VALUES ( ?, ?, ?, ? )";
        $stmt = $this->dbh->prepare($requete_sql);

        // Exécution de la requête SQL
        $resultats = $stmt->execute(array($fraisID, $employeID, $payeur, $typeCarte));
        return $resultats;
    }

	public function recupUtilisateurs() {
        // Préparation de la requête SQL
        $requete_sql = "SELECT * FROM Employes";

		// Exécution de la requête SQL
		$stmt = $this->dbh->query($requete_sql);

		// Récupération des résultats
		$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    }
}