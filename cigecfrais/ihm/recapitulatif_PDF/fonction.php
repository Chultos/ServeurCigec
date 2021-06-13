<?php

function SQL($reqSQL)
{
    // Connexion à la base de données
    $dsn = "sqlite:./bdd/cigecfrais.sqlite";
    $dbh = new PDO($dsn);
    // Lecture d’enregistrements
    $resultat = $dbh->query($reqSQL);
    // Récupération des résultats (ligne par ligne)
    $DD = $resultat->fetchAll(\PDO::FETCH_ASSOC);
    // Fermeture de la connexion
    $dbh = NULL;
    return $DD;
}

function ajaxSQL($reqSQL)
{
    // Connexion à la base de données
    $dsn = "sqlite:../../bdd/cigecfrais.sqlite";
    $dbh = new PDO($dsn);
    // Lecture d’enregistrements
    $resultat = $dbh->query($reqSQL);
    // Récupération des résultats (ligne par ligne)
    $DD = $resultat->fetchAll(\PDO::FETCH_ASSOC);
    // Fermeture de la connexion
    $dbh = NULL;
    return $DD;
}
