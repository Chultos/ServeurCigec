//Fonction qui récupère les filtres pour faire un export CSV du tableau
//employe sert a changer le nom du fichier csv
function exportCSV(nomEmploye = "", prenomEmploye = "") {
    //Déclaration des variables
    var table, tr, str = "", frais = [];
    if(nomEmploye == "" && prenomEmploye == "") {
        var arrayHeader = ["Employe", "Chantier","Fournisseur","Type de Frais","Date","Prix (euros)"]
    } else {
        var arrayHeader = ["Chantier","Fournisseur","Type de Frais","Date","Prix (euros)", "A paye ?", "Carte"]
    }

    table = document.getElementById("tableRecherche");
    tr = table.getElementsByClassName("tr");

    //Si la ligne n'est pas cachée, on récupère les données des <td>
    for(i = 0; i < (tr.length); i++) {
        if(tr[i].style.display != "none") {
            td = tr[i].getElementsByClassName("td");
            for(j = 0; j < td.length - 1; j++) {
                str += td[j].innerText + ",";
            }
            frais[i] = str.split(",");
            frais[i].pop(); //On enlève le dernier objet vide ajouté par la virgule à la fin du td
            str = "";
        }  
    }

    var header = arrayHeader.join(",") + '\n';
    var csv = header;

    //Ajout des données du tableau dans le texte du csv
    frais.forEach( obj => {
        var row = [];
        for (key in obj) {
            if (obj.hasOwnProperty(key)) {
                row.push(obj[key]);
            }
        }
        csv += row.join(",")+"\n";

        //Remplace certains caractères non supportés par excel
        csv = csv.replace("€", "");

        csv = csv.replace("à", "a");
        csv = csv.replace("ä", "a");
        csv = csv.replace("â", "a");
        csv = csv.replace("ã", "a");
        csv = csv.replace("å", "a");

        csv = csv.replace("é", "e");
        csv = csv.replace("è", "e");
        csv = csv.replace("ê", "e");
        csv = csv.replace("ë", "e");
        
        csv = csv.replace("ï", "i");
        csv = csv.replace("î", "i");
        
        csv = csv.replace("ö", "o");
        csv = csv.replace("ô", "o");
        csv = csv.replace("õ", "o");

        csv = csv.replace("ü", "u");
        csv = csv.replace("û", "u");

        csv = csv.replace("ñ", "n");
    });

    //Création du fichier csv
    var csvData = new Blob([csv], { type: 'text/csv' });  
    var csvUrl = URL.createObjectURL(csvData);

    //Création d'un élément caché <a>
    var hiddenElement = document.createElement('a');
    hiddenElement.href = csvUrl;
    hiddenElement.target = '_blank';

    //Récupération des filtres
    var filtres = "";
    filtreDropdownCount = document.querySelectorAll('.filtreRechercheDropdown').length;
    filtreTextInputCount = document.querySelectorAll('.filtreRechercheTextInput').length;
    countModifStringFilename = 0;

    dropdowns = document.querySelectorAll('.filtreRechercheDropdown');
    textInputs = document.querySelectorAll('.filtreRechercheTextInput');

    //Ajout des filtres des menus déroulants dans le string
    for(i = 0; i < filtreDropdownCount; i++) {
        //Si le filtre n'est pas nul
        if(dropdowns[i].value != 0) {
            if(countModifStringFilename == 0) {
                filtres += dropdowns[i].value;
                countModifStringFilename++;
            } else {
                filtres += "+" + dropdowns[i].value;
                countModifStringFilename++;
            }
        }
    }

    //Ajout des filtres des champs de texte dans le string
    for(i = 0; i < filtreTextInputCount; i++) {
        //Si le filtre n'est pas nul
        if(textInputs[i].value != 0) {
            if(countModifStringFilename == 0) {
                filtres += textInputs[i].value;
                countModifStringFilename++;
            } else {
                filtres += "+" + textInputs[i].value;
                countModifStringFilename++;
            }
        }
    }

    //Remplace les / ( _ dans le nom du fichier ) du filtre date par des -
    filtres = filtres.replace("/", "-");
    
    //Si on se trouve sur la page des frais
    if(nomEmploye == "" && prenomEmploye == "") {
        //Si il n'y a pas de filtres, écrire Global a la place
        if(filtres != "") {
            hiddenElement.download = filtres + ".csv";
        } else {
            hiddenElement.download = "Global.csv";
        }
    } else {
        //Si on se trouve sur la page d'un employé
        if(filtres != "") {
            hiddenElement.download = nomEmploye + "." + prenomEmploye + "+" + filtres + ".csv";
        } else {
            hiddenElement.download = nomEmploye + "." + prenomEmploye + ".csv";
        }
    }

    //Clique sur l'élément caché <a> pour télécharger le fichier .csv
    hiddenElement.click();

}