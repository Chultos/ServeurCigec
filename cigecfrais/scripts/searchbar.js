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

//Fonction qui permet de filtrer un tableau avec deux menus dropdown
function trierTableDropdown(searchColumn1, searchColumn2) {
    // Declaration des variables
    var dropdown1, dropdown2, filter1, filter2, table, tr, trFiltered1 = [], td, i, txtValue;
    dropdown1 = document.getElementById("searchDropdown1");
    dropdown2 = document.getElementById("searchDropdown2");
    filter1 = dropdown1.value.toUpperCase();
    filter2 = dropdown2.value.toUpperCase();

    table = document.getElementById("tableRecherche");
    tr = table.getElementsByTagName("tr");

    var filteredCount = 0;
  
    if(filter1 != 0 || filter2 != 0) {
        // Boucle qui passe dans toutes les lignes du tableau et enlève celles qui ne correspondent pas
        // à la recherche
        //Filtre 1
        if(filter1 != 0) {
            for (i = 0; i < tr.length; i++) {
                if(i != 3) {
                    td = tr[i].getElementsByClassName("td")[searchColumn1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter1) > -1) {
                            tr[i].style.display = "";

                            //Rajoute la ligne dans le tableau de lignes valides
                            trFiltered1.push(tr[i]);
                            filteredCount++;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        } else {
            trFiltered1 = tr;
        }
        //Filtre 2
        if(filter2 != 0) {
            for (i = 0; i < trFiltered1.length; i++) {
                if(i != 3) {
                    td = trFiltered1[i].getElementsByClassName("td")[searchColumn2];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter2) > -1) {
                            trFiltered1[i].style.display = "";
                        } else {
                            trFiltered1[i].style.display = "none";
                        }
                    }
                }
            }
        }
    } else {
        // Boucle qui passe dans toutes les lignes du tableau et enlève celles qui ne correspondent pas
        // à la recherche
        for (i = 0; i < tr.length; i++) {
            tr[i].style.display = "";
        }
    }
}