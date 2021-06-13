//Fonction qui permet de filtrer un tableau avec un textinput
function trierTable(searchColumn) {
    // Declaration des variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tableRecherche");
    tr = table.getElementsByTagName("tr");
  
    // Boucle qui passe dans toutes les lignes du tableau et enlève celles qui ne correspondent pas
    // à la recherche
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[searchColumn];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}