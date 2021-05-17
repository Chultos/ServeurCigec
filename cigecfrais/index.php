<?php
// Inclusion de la classe pour accéder à la base de données
include("bdd.class.php");
// Inclusion des paramètres de configuration
include("config.php");

//========== IHM ==========
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

		//Récupération des employes
		$les_employes = $bdd->recupEmployes();

		include("./ihm/employes.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//Affichage de la page des chantiers
if ($_GET["ihm"] == "chantiers"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);

		//Récupération des chantiers
		$les_chantiers = $bdd->recupChantiers();

		include("./ihm/chantiers.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//Affichage de la page des frais
if ($_GET["ihm"] == "frais"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);

		//Récupération de la liste des frais
		$les_frais = $bdd->recupFrais();
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};

	include("./ihm/frais.php");
}

//Affichage de la page des frais d'un employé
if ($_GET["ihm"] == "fraisEmploye"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);

		//Employé choisi dans la liste de la page des employés
		$employeID = $_GET["employeID"];

		//Récupération des informations liées à cet employé
		$employe = $bdd->recupEmployeAvecID($employeID);
		$les_paiements = $bdd->recupPaiementsEmploye($employeID);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};

	include("./ihm/fraisEmploye.php");
}

//Affichage de la page d'édition de chantier
if ($_GET["ihm"] == "editionChantier"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);

		$chantierID = $_GET["chantierID"];
		$chantier = $bdd->recupChantierAvecID($chantierID);
		$chantierSupprimable = $bdd->chantierSupprimable($chantierID);

		include("./ihm/editionChantier.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//Affichage de la page d'ajout de chantier
if ($_GET["ihm"] == "ajoutChantier"){
	try {
		include("./ihm/ajoutChantier.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//Affichage de la page d'ajout d'employé
if ($_GET["ihm"] == "ajoutEmploye"){
	try {
		include("./ihm/ajoutEmploye.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//Affichage de la page d'édition d'un employé
if ($_GET["ihm"] == "editionEmploye"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);

		$employeID = $_GET["employeID"];
		$employe = $bdd->recupEmployeAvecID($employeID);
		$employeSupprimable = $bdd->employeSupprimable($employeID);

		include("./ihm/editionEmploye.php");
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};
}

//========== API ==========
//Lien qui permet de sauvegarder les frais
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

//Lien qui permet de récupérer les employés sous forme de tableau json
if ($_GET["api"] == "getEmployes"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$les_employes = $bdd->recupEmployes();
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	include("api/listeEmployes.php");
}

//Lien qui permet de récupérer les chantiers sous forme de tableau json
if ($_GET["api"] == "getChantiers"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$les_chantiers = $bdd->recupChantiers();
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	include("api/listeChantiers.php");
}

//Lien qui permet de changer l'état d'un chantier
if ($_GET["api"] == "changerChantierEtat"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$les_employes = $bdd->changerChantierEtat($_GET["chantierID"], $_GET["chantierEtat"]);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	//Redirection vers la liste des chantiers
	header("Location: /cigecfrais/?ihm=chantiers");
}

//Lien qui permet l'édition d'un chantier
if ($_GET["api"] == "editionChantier"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$bdd->editerChantier($_GET["chantierID"], $_GET["nouveauNom"], $_GET["nouveauNumero"]);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	//Redirection vers la liste des chantiers
	header("Location: /cigecfrais/?ihm=chantiers");
}

//Lien qui permet de supprimer un chantier
if ($_GET["api"] == "supprimerChantier"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$bdd->supprimerChantier($_GET["chantierID"]);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	//Redirection vers la liste des chantiers
	header("Location: /cigecfrais/?ihm=chantiers");
}

//Lien qui permet d'ajouter un chantier
if ($_GET["api"] == "ajoutChantier"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$bdd->ajouterChantier($_GET["nom"], $_GET["numeroID"]);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	//Redirection vers la liste des chantiers
	header("Location: /cigecfrais/?ihm=chantiers");
}

//Lien qui permet d'ajouter un employé
if ($_GET["api"] == "ajoutEmploye"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$bdd->ajouterEmploye($_GET["nom"], $_GET["prenom"], $_GET["numeroCarte"]);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	//Redirection vers la liste des chantiers
	header("Location: /cigecfrais/?ihm=employes");
}

//Lien qui permet de changer l'état d'un employé
if ($_GET["api"] == "changerEmployeEtat"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$les_employes = $bdd->changerEmployeEtat($_GET["employeID"], $_GET["employeEtat"]);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	//Redirection vers la liste des chantiers
	header("Location: /cigecfrais/?ihm=employes");
}

//Lien qui permet d'éditer un employé
if ($_GET["api"] == "editionEmploye"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$bdd->editerEmploye($_GET["employeID"], $_GET["nouveauNom"], $_GET["nouveauPrenom"], $_GET["nouveauNumeroCarte"]);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	//Redirection vers la liste des chantiers
	header("Location: /cigecfrais/?ihm=employes");
}

//Lien qui permet de supprimer un employé
if ($_GET["api"] == "supprimerEmploye"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);
		$bdd->supprimerEmploye($_GET["employeID"]);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	}
	//Redirection vers la liste des chantiers
	header("Location: /cigecfrais/?ihm=employes");
}

//Lien qui permet d'exporter les frais en CSV
if ($_GET["api"] == "exportCSV"){
	try {
		// Connexion à la base de données
		$bdd = new Bdd(CHEMIN_BDD);

		//Récupération de la liste des frais
		$nbFiltres = 0;
		if($_GET["nomChantier"] != "0") {
			$chantierID = $bdd->recupChantierIDAvecNom($_GET["nomChantier"]);
			$nbFiltres += 1;
		}
		if($_GET["fraisType"] != "0") {
			$fraisTypeID = $bdd->recupFraisTypeIDAvecNom($_GET["fraisType"]);
			$nbFiltres += 1;
		}
		$les_frais = $bdd->recupFrais($nbFiltres, $chantierID, $fraisTypeID);
	}
	catch (PDOException $erreur) {
		die("Erreur : ".$erreur->getMessage());
	};

	//Ouverture d'un fichier
	if($_GET["nomChantier"] != "0" && $_GET["fraisType"] != "0") {
		//Nom du fichier si il y a les deux filtres
		$file = fopen('csv/'.$_GET["nomChantier"].'.'.$_GET["fraisType"]." ".date('d-m-Y').'.csv', 'w');
	} 
	else if($_GET["nomChantier"] != "0") {
		//Nom du fichier si il y'a le filtre Chantier
		$file = fopen('csv/'.$_GET["nomChantier"].' '.date('d-m-Y').'.csv', 'w');
	} 
	else if($_GET["fraisType"] != "0") {
		//Nom du fichier si il y a le filtre fraisType
		$file = fopen('csv/'.$_GET["fraisType"].' '.date('d-m-Y').'.csv', 'w');
	} 
	else {
		//Nom du fichier si il n'y a pas de filtre
		$file = fopen('csv/global '.date('d-m-Y').'.csv', 'w');
	}

	//Ecriture des frais dans le fichier
	foreach($les_frais as $un_frais) {
		$chantier = $bdd->recupChantierAvecID($un_frais["chantierID"]);
		$fraisType = $bdd->recupFraisType($un_frais["fraisTypeID"]);
		$lienPhoto = $bdd->recupLienPhotoAvecID($un_frais["photoID"]);

		$data = array($chantier["nom"],
					  $un_frais["fournisseur"],
					  $fraisType["type"],
					  $un_frais["date"],
					  $un_frais["prix"]
		);
		fputcsv($file, $data);
  	}

	//Fermeture du fichier
	fclose($file);

	//Redirection vers la liste des frais
	header("Location: /cigecfrais/?ihm=frais");
}
?>
