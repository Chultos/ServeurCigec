<?php
header('Content-Type: application/json');
include("fonction.php");
$Compteur = 0;
$NomPremonBrut = $_GET['NomPremonBrut'];
$typeSQL = $_GET['typeSQL'];
$NomEtPremon = explode(" ", $NomPremonBrut);
if ($typeSQL == 1) {
    $Periode = ajaxSQL("SELECT date FROM Frais, Paiements, Employes  WHERE Frais.id=Paiements.fraisID AND Employes.id=Paiements.employeID AND Employes.nom='$NomEtPremon[0]' AND Employes.prenom='$NomEtPremon[1]';");
} else if ($typeSQL == 2) {
    $Periode = ajaxSQL("SELECT Frais.id,Frais.fraisTypeID,Frais.prix,Frais.tva5_5,Frais.tva10,Frais.tva20,Frais.date,Frais.fournisseur,Chantiers.numeroID,Chantiers.nom,Paiements.typeCarte,Photos.lien 
                        FROM Chantiers, Employes, Frais, FraisType, Paiements, Photos  
                        WHERE Frais.id=Paiements.fraisID AND Frais.chantierID = Chantiers.id AND Employes.id=Paiements.employeID AND Paiements.employeID = Employes.id  AND Frais.fraisTypeID = FraisType.id  AND Frais.photoID = Photos.id 
                        AND Employes.nom='$NomEtPremon[0]' AND Employes.prenom='$NomEtPremon[1]';");
}

if ($Periode == null) {
    echo json_encode("Pas de donnée trouver");
} else {
    echo json_encode($Periode);
}
