<?php
$idFrais = $_GET['idFrais'];
$Colonne = $_GET['Colonne'];
$NvPrix = $_GET['NvPrix'];
// Connexion à la base de données
$dsn = "sqlite:../../bdd/cigecfrais.sqlite";
$dbh = new PDO($dsn);
// Préparation de la requete sql
$requete_sql = "UPDATE frais SET $Colonne=\"$NvPrix\" WHERE frais.id=$idFrais;";
$stmt = $dbh->prepare($requete_sql);
//Envoi de la requete
$resultats = $stmt->execute();
return $resultats;
