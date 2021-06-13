<?php
include('./ihm/en-tete.php');
?>

<body>
    <h1>Récapitulatif</h1>
    <br><br><br>
    <!--Zone pour les employés -->
    <div class="input-group mb-3">
        <label class="input-group-text" for="EmployeSelection">Employé:</label>
        <input list="Employes" onchange="ActuPeriodeTableau()" type="text" class="form-control" placeholder=". . ." aria-label=". . ." aria-describedby="basic-addon1" id="EmployeSelection">
        <datalist id="Employes">
            <?php
            include("fonction.php");

            $Employes = SQL("SELECT nom, prenom FROM Employes ORDER BY nom ASC ");
            foreach ($Employes as $row) {
                print "<option>" . $row["nom"] . " " . $row["prenom"] . "</option>";
            }
            ?>
        </datalist>
    </div>


    <!--Zone pour les périodes -->
    <div class="input-group mb-3">

        <div class="input-group-prepend">
            <label class="input-group-text" for="PeriodeSelection">Période :</label>
        </div>

        <select onchange="tableauTaxe()" class="custom-select" id="PeriodeSelection">
            <option selected>. . .</option>
        </select>
    </div>

    <!--Zone pour les taxes -->
    <table class="table table-hover" cellspacing="0">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Objet Frais</th>
                <th scope="col">Nº CHANTIER-NOM </th>
                <th scope="col">Repas</th>
                <th scope="col">Peage-Stationnement </th>
                <th scope="col">Carburant</th>
                <th scope="col">Materiel</th>
                <th scope="col">Total H.T</th>
                <th scope="col">Tva5.5%</th>
                <th scope="col">Tva10%</th>
                <th scope="col">Tva20%</th>
                <th scope="col">Total TTC</th>
                <th scope="col">Type Carte</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody id="tableau">
        </tbody>
    </table>

    <!--Bouton de génération du pdf -->
    <button onclick="BoutonPDF()" type="button" class="btn btn-primary">PDF</button>



    <script>
        function tableauTaxe() {
            var NomPremonBrut = document.getElementById("EmployeSelection").value;

            var valeur = document.getElementById("PeriodeSelection");
            var Periode = valeur.options[valeur.selectedIndex].text;

            $.ajax({
                url: './ihm/recapitulatif_PDF/requeteSQL.php?NomPremonBrut=' + NomPremonBrut + '&typeSQL=2',
                type: 'GET',
                dataType: 'json',
                success: function(reponse_Json, statut) {
                    var options = '';
                    var Compteur = 0;
                    for (var x = 0; x < reponse_Json.length; x++) {

                        if (TransPeriode(reponse_Json[x].date) == Periode) {
                            Compteur++;
                            options += '<tr class="table-success" id=' + (Compteur) + '><th scope="row">' + (Compteur) + '</th>';
                            options += '<td>' + TransPeriode(reponse_Json[x].date) + '</td>';
                            options += '<td>' + reponse_Json[x].fournisseur + '</td>';
                            options += '<td>' + reponse_Json[x].numeroID + '-' + reponse_Json[x].nom + '</td>';

                            switch (Number(reponse_Json[x].fraisTypeID)) {
                                case 1:
                                    //Autoroute -> Peage Stationement
                                    options += '<td></td>';
                                    options += '<td><input onchange="SQL_Update(' + reponse_Json[x].fraisTypeID + ')" type="text" class="form-control" value="' + reponse_Json[x].prix + '" ></td>';
                                    options += '<td></td><td></td>';
                                    break;
                                case 2:
                                    //Carburant -> Carburant
                                    options += '<td></td><td></td>';
                                    options += '<td><input onchange="SQL_Update(' + reponse_Json[x].fraisTypeID + ')" type="text" class="form-control" value="' + reponse_Json[x].prix + '" ></td>';
                                    options += '<td></td>';
                                    break;
                                case 3:
                                    //Hotel
                                    break;
                                case 4:
                                    //Restauration -> Repas
                                    options += '<td><input onchange="SQL_Update(' + reponse_Json[x].fraisTypeID + ')" type="text" class="form-control" value="' + reponse_Json[x].prix + '" ></td>';
                                    options += '<td></td><td></td><td></td>';
                                    break;
                                case 5:
                                    //Materiel -> Materiel
                                    options += '<td></td><td></td><td></td>';
                                    options += '<td><input onchange="SQL_Update(' + reponse_Json[x].fraisTypeID + ')" type="text" class="form-control" value="' + reponse_Json[x].prix + '" ></td>';
                                    break;
                                default:
                                    console.log("Pas de fraisTypeID trouvé, switch de la fonction js tableauTaxe");

                            }
                            options += '<td>' + reponse_Json[x].prix + '</td>';
                            var totalHTT = Number(reponse_Json[x].prix);
                            //tva 5.5%
                            let tva5_5 = "'tva5_5'";

                            options += '<td><input onchange="SQL_Update(' + reponse_Json[x].id + ',' + tva5_5 + ',this)" type="text" class="form-control" list="suggestion5_5" value="' + verifNULL(reponse_Json[x].tva5_5) + '" ></td>';
                            totalHTT += Number(reponse_Json[x].tva5_5);
                            //tva 10%
                            let tva10 = "'tva10'";
                            options += '<td><input onchange="SQL_Update(' + reponse_Json[x].id + ',' + tva10 + ',this)" type="text" class="form-control" value="' + verifNULL(reponse_Json[x].tva10) + '"></td>';
                            totalHTT += Number(reponse_Json[x].tva10);
                            //tva 20%
                            let tva20 = "'tva20'";
                            options += '<td><input onchange="SQL_Update(' + reponse_Json[x].id + ',' + tva20 + ',this)" type="text" class="form-control" value="' + verifNULL(reponse_Json[x].tva20) + '"></td>';
                            totalHTT += Number(reponse_Json[x].tva20);
                            //total TTC

                            options += '<td>' + totalHTT + '</td>';
                            //type carte
                            options += '<td>' + reponse_Json[x].typeCarte + '</td>';
                            //Image
                            options += '<td><a><img src = "assets/img/image-logo_x32.png" onclick = "window.open(\''+ reponse_Json[x].lien +'\',\'popup\',\'width=600,height=600\')" ></a></td > ';
                            //Fin d'une ligne de tableau
                            options += '</tr>';
                        }

                    }

                    $('#tableau').html(options);

                },

                error: function(resultat, statut, erreur) {
                    if (erreur = "SyntaxError") {
                        $('#PeriodeSelection').html('<option value=1>. . .</option>');
                    } else {
                        console.log("ERREUR ajax Get:" + resultat + ":_:" + statut + ":_:" + erreur);
                    }
                }

            });


        }

        function ActuPeriodeTableau() {
            ActualisationPeriode();
            tableauTaxe();
        }

        function verifNULL(objet) {
            if (objet == null) {
                objet = " ";
            }
            console.log(objet);
            return objet;
        }

        function SQL_Update(idFrais, Colonne, Objet) {
            var valeur = Objet.value;
            if (valeur.indexOf(',') > -1) {
                var a = valeur.split(",");
                valeur = a[0] + "." + a[1];
            }

            $.ajax({
                url: './ihm/recapitulatif_PDF/updateSQL.php?idFrais=' + idFrais + '&Colonne=' + Colonne + '&NvPrix=' + valeur,
                type: 'post',
                success: function(data) {
                    console.log(data);
                },
                error: function(resultat, statut, erreur) {
                    console.log("ERREUR ajax Get:" + resultat + ":_:" + statut + ":_:" + erreur);
                }
            });
        }

        function BoutonPDF() {
            var NomPremonBrut = document.getElementById("EmployeSelection").value;

            var valeur = document.getElementById("PeriodeSelection");
            var Periode = valeur.options[valeur.selectedIndex].text;

            window.open("./ihm/recapitulatif_PDF/pdf.php?NomPremonBrut=" + NomPremonBrut + "&Periode=" + Periode);
        }

        function ActualisationPeriode() {
            var NomPremonBrut = document.getElementById("EmployeSelection").value;
            $.ajax({
                url: './ihm/recapitulatif_PDF/requeteSQL.php?NomPremonBrut=' + NomPremonBrut + '&typeSQL=1',
                type: 'GET',
                dataType: 'json',
                success: function(reponse_Json, statut) {
                    if (reponse_Json == "Pas de donnée trouver") {
                        $('#PeriodeSelection').html('<option value = 1>Pas de donnée trouver</option>');
                    } else {
                        var options = '<option value="0" selected hidden>Choisir une période</option>';
                        var periodeA, periode = "a";
                        for (var x = 0; x < reponse_Json.length; x++) {
                            periode = TransPeriode(reponse_Json[x].date);
                            if (periode != periodeA) {
                                options += '<option value="' + (x + 1) + '">' + periode + '</option>';
                            }
                            periodeA = periode;
                        }
                        $('#PeriodeSelection').html(options);
                    }
                },

                error: function(resultat, statut, erreur) {
                    if (erreur = "SyntaxError") {
                        $('#PeriodeSelection').html('<option value=1>. . .</option>');
                    } else {
                        console.log("ERREUR ajax Get:" + resultat + ":_:" + statut + ":_:" + erreur);
                    }
                }

            });
        }

        function TransPeriode(valeur) {
            //On enleve l'heure
            const date = valeur.split(" ");
            //On enleve la date du jour et on sépare mois et années
            const periode = date[0].split("/");
            //On forme la période par rapport à la date
            var Mois = {
                "01": "Janvier",
                "02": "Février",
                "03": "Mars",
                "04": "Avril",
                "05": "Mai",
                "06": "Juin",
                "07": "Juillet",
                "08": "Août",
                "09": "Septembre",
                "10": "Octobre",
                "11": "Novembre",
                "12": "Décembre"
            };
            let a = Mois[periode[01]] + '-' + periode[2];
            return a;


        }
    </script>
</body>

<?php
include("ihm/pied-de-page.php");
?>