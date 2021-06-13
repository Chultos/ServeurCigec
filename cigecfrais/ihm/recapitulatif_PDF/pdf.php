
<?php
require('fpdf.php');
include("fonction.php");

//Récupération du nom et de la période
$NomPremonBrut = $_GET['NomPremonBrut'];
$PeriodeBrut = $_GET['Periode'];

$NomEtPremon = explode(" ", $NomPremonBrut);
//Fonction pour la génération du pdf
class PDF extends FPDF
{

    function Entete()
    {
        $this->Image('../../assets/img/logo-cigecBis.png', 10, 3, 15, 15);
        $this->Cell(20, 10);
        $this->Ln();
    }

    //Table
    function NomPrenomVehiclePeriode($P)
    {
        // Couleurs, Hauteur de ligne et polices
        $this->SetFillColor(220, 220, 220);
        //$this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B', '4.5');
        $Hauteur = 2.4;
        $Largeur = array(6, 30, 10, 30, 9, 15, 8, 15);
        $EnTete = array('Nom :', $P[0], 'Prenom :', $P[1], 'Vehicule :', $P[2], 'Periode :', $P[3]);
        for ($i = 0; $i < count($EnTete); $i++) {
            $EnTete[$i] = iconv('utf-8', 'latin1', $EnTete[$i]);
            $this->Cell($Largeur[$i], $Hauteur, $EnTete[$i], 0, 0, '');
        }
        $this->Ln();
        $this->Ln();
    }


    function Tableau($NomEtPremon, $PeriodeBrut)
    {

        // Couleurs, Hauteur de ligne et polices
        $this->SetFillColor(220, 220, 220);
        //$this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B', '4.5');
        $Hauteur = 2.4;
        $Largeur = array(4, 23, 20, 45, 20, 30, 15, 10, 10, 10, 10, 10, 10, 10);

        //En-tête du premier tableau
        $EnTete = array('N', 'DATE', 'OBJET FRAIS', ' Nº CHANTIER-NOM', 'REPAS', 'PEAGE-STATIONNEMENT', 'CARBURANT', 'MATERIEL', 'TOTAL H.T', 'TVA 5,50%', 'TVA 10%', 'TVA 20%', 'TOTAL TTC', 'Type Carte');
        for ($i = 0; $i < count($EnTete); $i++) {
            $EnTete[$i] = iconv('utf-8', 'latin1', $EnTete[$i]);
            $this->Cell($Largeur[$i], $Hauteur, $EnTete[$i], 1, 0, 'C');
        }
        $this->Ln();
        // Restauration de couleur et de police
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $données = ajaxSQL(
            "SELECT Frais.date,Frais.fournisseur,Chantiers.numeroID,Chantiers.nom,Frais.fraisTypeID,Frais.prix,Paiements.typeCarte,Frais.tva5_5,Frais.tva10,Frais.tva20
            FROM Chantiers, Employes, Frais, FraisType, Paiements  
            WHERE Frais.id=Paiements.fraisID AND Frais.chantierID = Chantiers.id AND Employes.id=Paiements.employeID AND Paiements.employeID = Employes.id  AND Frais.fraisTypeID = FraisType.id 
            AND Employes.nom='$NomEtPremon[0]' AND Employes.prenom='$NomEtPremon[1]';"
        );

        // Données 
        $fill = false;
        $Compteur = 1;
        $ListeChantiers = array();
        $TotalBas = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
        $TotalHotel = 0.0;
        $Mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $Periode = explode("-", $PeriodeBrut);

        //Création du 1er tableau

        foreach ($données as $row) {
            //Verification de la date
            $dateS = explode(" ", $row["date"]);
            $date = explode("/", $dateS[0]);
            if ($date[2] == $Periode[1] && $Mois[floatval($date[1])] == $Periode[0]) {
                //Format : Cell(Largeur, Hauteur, texte, bordure/position bordure, position curseur,Position texte,couleur case,"url");"
                //Compteur
                $this->Cell($Largeur[0], $Hauteur, $Compteur, 'LR', 0, 'R', $fill);
                //Date
                $this->Cell($Largeur[1], $Hauteur, $dateS[0], 'LR', 0, 'R', $fill);
                //Objet frais
                $this->Cell($Largeur[2], $Hauteur, iconv('utf-8', 'latin1', $row["fournisseur"]), 'LR', 0, 'L', $fill);
                //N Chantier - Nom
                $this->Cell($Largeur[3], $Hauteur, $row["numeroID"] . " - " . iconv('utf-8', 'latin1', $row["nom"]), 'LR', 0, 'L', $fill);
                array_push($ListeChantiers, iconv('utf-8', 'latin1', $row["numeroID"] . " - " . iconv('utf-8', 'latin1', $row["nom"])));

                switch ($row["fraisTypeID"]) {
                    case 1: {
                            //Autoroute -> Peage Stationement
                            $this->Cell($Largeur[4], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[5], $Hauteur, $row["prix"], 'LR', 0, 'R', $fill);
                            $this->Cell($Largeur[6], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[7], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $TotalBas[1] = $row["prix"];
                            break;
                        }
                    case 2: {
                            //Carburant -> Carburant
                            $this->Cell($Largeur[4], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[5], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[6], $Hauteur, $row["prix"], 'LR', 0, 'R', $fill);
                            $this->Cell($Largeur[7], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $TotalBas[2] += $row["prix"];
                            break;
                        }
                    case 3: {
                            //Hotel
                            $this->Cell($Largeur[4], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[5], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[6], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[7], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $TotalHotel += $row["prix"];
                            break;
                        }
                    case 4: {
                            //Restauration -> Repas
                            $this->Cell($Largeur[4], $Hauteur, $row["prix"], 'LR', 0, 'R', $fill);
                            $this->Cell($Largeur[5], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[6], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[7], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $TotalBas[0] += $row["prix"];
                            break;
                        }
                    case 5: {
                            //Materiel -> Materiel
                            $this->Cell($Largeur[4], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[5], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[6], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[7], $Hauteur, $row["prix"], 'LR', 0, 'R', $fill);
                            $TotalBas[3] += $row["prix"];
                            break;
                        }
                    default: {
                            $this->Cell($Largeur[4], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[5], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[6], $Hauteur, " ", 'LR', 0, 'L', $fill);
                            $this->Cell($Largeur[6], $Hauteur, " ", 'LR', 0, 'L', $fill);
                        }
                }


                //Total H.T

                $this->Cell($Largeur[8], $Hauteur, $row["prix"], 'LR', 0, 'L', $fill);
                $TotalBas[4] += $row["prix"];
                $TotalTTC = floatval($row["prix"]);
                //TVA 5.5%
                $this->Cell($Largeur[9], $Hauteur, $row["tva5_5"], 'LR', 0, 'L', $fill);
                $TotalBas[5] += floatval($row["tva5_5"]);
                $TotalTTC += floatval($row["tva5_5"]);
                //TVA 10%
                $this->Cell($Largeur[10], $Hauteur, $row["tva10"], 'LR', 0, 'L', $fill);
                $TotalBas[6] += floatval($row["tva10"]);
                $TotalTTC += floatval($row["tva10"]);
                //TVA 20%
                $this->Cell($Largeur[11], $Hauteur, $row["tva20"], 'LR', 0, 'L', $fill);
                $TotalBas[7] += floatval($row["tva20"]);
                $TotalTTC += floatval($row["tva20"]);
                //Total TTC
                $this->Cell($Largeur[12], $Hauteur, $TotalTTC, 'LR', 0, 'L', $fill);
                $TotalBas[8] += $TotalTTC;
                //Carte perso?
                $this->Cell($Largeur[13], $Hauteur, $row["typeCarte"], 'LR', 0, 'L', $fill);

                //Fin, retour a la ligne
                $this->Ln();
                $fill = !$fill;
                $Compteur++;
            }
        }
        //Tant que le tableau n'est pas à 20 frais (éviter un gros vide)
        while ($Compteur <= 20) {
            $this->Cell($Largeur[0], $Hauteur, $Compteur, 'LR', 0, 'R', $fill);
            for ($i = 1; $i <= 13; $i++) {
                $this->Cell($Largeur[$i], $Hauteur, " ", 'LR', 0, 'C', $fill);
            }
            $this->Ln();
            $fill = !$fill;
            $Compteur++;
        }
        $this->SetFont('', 'B', '4.5');

        //Derniere ligne du 1er tableau
        for ($i = 0; $i < count($EnTete); $i++) {
            if ($i == 1) {
                $this->Cell($Largeur[$i], $Hauteur, "TOTAL", 1, 0, 'C');
            } elseif ($i > 3 && $i < 13) {
                $this->Cell($Largeur[$i], $Hauteur, $TotalBas[$i - 4], 1, 0, 'C');
            } else {
                $this->Cell($Largeur[$i], $Hauteur, " ", 1, 0, 'C');
            }
        }
        $this->SetFont('');



        //Création du 2ème tableau


        $this->Ln();
        $this->Ln();
        $this->Ln();

        //En-tête du deuxieme tableau
        $Largeur2 = array(4, 23, 15, 30, 30, 25, 20, 18, 17, 17, 19);
        $EnTete2 = array(' ', 'Données', ' Nº CHANTIER-NOM', 'Somme de repas', 'Somme de MISSION-RECEPTION', 'Somme de PEAGE-STATIONNEMENT', 'Somme de CARBURANT', 'Somme de MATERIEL', 'Somme de TVA 5,50%', 'Somme de TVA 10%', 'Somme de TVA 20%', 'Somme de TOTAL TTC');

        $this->Cell($Largeur2[1], $Hauteur, $EnTete2[0], 1, 0);
        $this->Cell(191, $Hauteur, iconv('utf-8', 'latin1', $EnTete2[1]), 1, 0);
        $this->Ln();

        //Intérieur du deuxieme tableau



        $this->Cell($Largeur2[1], $Hauteur, iconv('utf-8', 'latin1', $EnTete2[2]), 1, 0);
        for ($i = 3; $i < count($EnTete2); $i++) {
            $EnTete2[$i] = iconv('utf-8', 'latin1', $EnTete2[$i]);
            $this->Cell($Largeur2[$i - 1], $Hauteur, $EnTete2[$i], 1, 0, 'L');
        }
        $this->Ln();
        //trie des chantiers
        $ListeChantiers = array_unique($ListeChantiers);
        foreach ($ListeChantiers as $Chantiers) {
            $SommeTotal = 0.0;
            $tva = array(0.0, 0.0, 0.0);
            $prix = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
            $this->Cell($Largeur2[1], $Hauteur, $Chantiers, 1, 0, 'L');
            foreach ($données as $row) {

                //Verification de la date
                $dateS = explode(" ", $row["date"]);
                $date = explode("/", $dateS[0]);
                if ($date[2] == $Periode[1] && $Mois[floatval($date[1])] == $Periode[0]) {
                    if (($row["numeroID"] . " - " . $row["nom"]) == $Chantiers) {

                        switch ($row["fraisTypeID"]) {
                            case 1: {
                                    //Autoroute -> Peage Stationement
                                    $prix[2] += floatval($row["prix"]);
                                    break;
                                }
                            case 2: {
                                    //Carburant -> Carburant
                                    $prix[3] += floatval($row["prix"]);
                                    break;
                                }
                            case 3: {
                                    //Hotel
                                    $prix[1] += floatval($row["prix"]);
                                    break;
                                }
                            case 4: {
                                    //Restauration -> Repas
                                    $prix[0] += floatval($row["prix"]);
                                    break;
                                }
                            case 5: {
                                    //Materiel -> Materiel
                                    $prix[4] += floatval($row["prix"]);
                                    break;
                                }
                            default: {
                                }
                        }
                        $tva[0] += floatval($row["tva5_5"]);
                        $tva[1] += floatval($row["tva10"]);
                        $tva[2] += floatval($row["tva20"]);
                    }
                }
            }

            //Somme de type
            for ($i = 0; $i < 5; $i++) {
                if ($i < 5) {
                    $this->Cell($Largeur2[$i + 2], $Hauteur, $prix[$i], 1, 0, 'C');
                    $SommeTotal += $prix[$i];
                }
            }
            //Somme de taxe
            for ($i = 0; $i < 3; $i++) {
                if ($i < 5) {
                    $this->Cell($Largeur2[$i + 7], $Hauteur, $tva[$i], 1, 0, 'C');
                    $SommeTotal += $tva[$i];
                }
            }
            //Somme de total
            $this->Cell($Largeur2[10], $Hauteur, $SommeTotal, 1, 0, 'C');
            $this->Ln();
        }



        $this->Cell($Largeur2[1], $Hauteur, iconv('utf-8', 'latin1', 'Total général'), 1, 0);
        for ($i = 0; $i < 9; $i++) {

            switch ($i) {
                case 0: {
                        $this->Cell($Largeur2[$i + 2], $Hauteur, $TotalBas[$i], 1, 0, 'C');
                        break;
                    }
                case 1: {
                        $this->Cell($Largeur2[$i + 3], $Hauteur, $TotalHotel, 1, 0, 'C');
                        break;
                    }
                default: {
                        if ($i < 5) {
                            $this->Cell($Largeur2[$i + 2], $Hauteur, $TotalBas[$i - 1], 1, 0, 'C');
                        } elseif ($i > 5) {
                            $this->Cell($Largeur2[$i + 1], $Hauteur, $TotalBas[$i - 1], 1, 0, 'C');
                        }
                    }
            }
        }
        $this->Cell($Largeur2[10], $Hauteur, $TotalBas[8], 1, 0, 'C');
        $this->Ln();
    }



    function Images($NomEtPremon, $PeriodeBrut)
    {
        $données = ajaxSQL(
            "SELECT Frais.date,Photos.lien
        FROM Chantiers, Employes, Frais, FraisType, Paiements,Photos  
        WHERE Photos.id = Frais.photoID AND Frais.id=Paiements.fraisID AND Frais.chantierID = Chantiers.id AND Employes.id=Paiements.employeID AND Paiements.employeID = Employes.id  AND Frais.fraisTypeID = FraisType.id 
        AND Employes.nom='$NomEtPremon[0]' AND Employes.prenom='$NomEtPremon[1]';"
        );

        $Compteur = 1;
        $Mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $Periode = explode("-", $PeriodeBrut);


        foreach ($données as $row) {
            //Verification de la date
            $dateS = explode(" ", $row["date"]);
            $date = explode("/", $dateS[0]);
            if ($date[2] == $Periode[1] || $Mois[floatval($date[1])] == $Periode[0]) {
                //Verification que le fichier existe
                if (file_exists('../../' . $row["lien"]) && $row["lien"] != '') {
                    $this->Ln();
                    $this->Cell(40, 2.4, 'N-' . $Compteur . ': ', 0, 0, 'C');
                    $this->Ln();
                    $this->Image('../../' . $row["lien"]);
                } else {
                    $this->Ln();
                    $this->Cell(40, 2.4, 'N-' . $Compteur . ': ' . iconv('utf-8', 'latin1', "Pas de photo trouvée"), 0, 0, 'C');
                    $this->Ln();
                }
                $Compteur++;
            }
        }
    }
}

//Géneration du pdf
$P = array($NomEtPremon[0], $NomEtPremon[1], "X", $PeriodeBrut);
$pdf = new PDF();

$pdf->SetFont('Arial', '', 10);
$pdf->AddPage('L');
$pdf->Entete();
$pdf->NomPrenomVehiclePeriode($P);
$pdf->Tableau($NomEtPremon, $PeriodeBrut);
$pdf->AddPage();
$pdf->Images($NomEtPremon, $PeriodeBrut);
$pdf->Output();
?>