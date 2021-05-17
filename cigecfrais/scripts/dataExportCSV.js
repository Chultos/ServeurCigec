//Fonction qui récupère les filtres pour faire un export CSV du tableau
function exportCSV() {
    //Déclaration des variables
    var nomChantier, fraisType, dropdownChantier, dropdownFraisType;

    //Récupération  des filtres dans les menus dropdown
    dropdownChantier = document.getElementById("searchDropdown1");
    dropdownFraisType = document.getElementById("searchDropdown2");

    nomChantier = dropdownChantier.value;
    fraisType = dropdownFraisType.value;

    //Redirection vers la page qui permet l'export des données
    window.location.href = "/cigecfrais/?api=exportCSV&nomChantier="+nomChantier+"&fraisType="+fraisType;
}
