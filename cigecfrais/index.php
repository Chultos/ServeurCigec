<?php
// Inclusion de la classe pour accéder à la base de données
include("bdd.class.php");
// Inclusion des paramètres de configuration
include("config.php");

//Affichage de la page d'accueil
if ($_GET["ihm"] == "accueil"){
	try {
		include("./ihm/accueil.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//Affichage de la page des employés
if ($_GET["ihm"] == "employes"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);

		//Récupération des utilisateurs
		$les_employes = $bdd->recupUtilisateurs();

		include("./ihm/employes.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//Affichage de la page des chantiers
if ($_GET["ihm"] == "chantiers"){
	try {
		include("./ihm/chantiers.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//Affichage de la page d'evolution des frais
if ($_GET["ihm"] == "evolution"){
	try {
		include("./ihm/evolution.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

if ($_GET["api"] == "sauvegarderFrais"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		
		//Variables transmises dans le lien de la requête
		$nbPersonnes = $_GET["nbPersonnes"];
		$lienPhoto = $_GET["lienPhoto"];
		$prix = $_GET["prix"];
		$fournisseur = $_GET["fournisseur"];
		$date = $_GET["date"];
		$nbNuits = $_GET["nbNuits"]; // Envoyés sous forme de total de tous les employés du frais
        $nbRepas = $_GET["nbRepas"]; //
		$immatriculation = $_GET["immatriculation"];
		$compteur = $_GET["compteur"];
		$chantierID = $_GET["chantierID"];
		$fraisTypeID = $_GET["fraisTypeID"];
	
		//Ajout des données
		$bdd->ajouterFrais($nbPersonnes, $lienPhoto, $prix, $fournisseur, $date, $nbRepas, $nbNuits, $immatriculation, $compteur, $chantierID, $fraisTypeID, $typeCarte);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

if ($_GET["api"] == "getEmployes"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$les_employes = $bdd->recupUtilisateurs();
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	include("api/listeEmployes.php");
}
?>
