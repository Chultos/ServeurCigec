function filtrageDropdownDansColonne(colonneRecherche, id) {
    // Declaration des variables
    var dropdown, filtre, table, tr, td, i, j, txtValue, champCache, lignesCachees, ligneValue, tableauFiltres = [];
    dropdown = document.getElementById("filtreRechercheDropdown" + id);
    champCache = document.getElementById("filtreCache" + id);

    //Récupération des lignes déja modifiées par le filtre
    lignesCachees = champCache.value.split(" ");
    lignesCachees.pop(); //On enlève la valeur en trop à cause des espaces
    champCache.value = "";

    //Récupération de la valeur du filtre
    filtre = dropdown.value.toUpperCase();

    table = document.getElementById("tableRecherche");
    tr = table.getElementsByClassName("tr");
    
    //Nombre de champs cachés sur la page
    var champCacheCount = document.querySelectorAll('.filtreCache').length;
        
    //Boucle qui passe dans tout les champs cachés pour faire un tableau de toutes les lignes 
    //cachées par les autres filtres -- Chaque valeur est unique
    for(j = 0; j < champCacheCount; j++) {
        //On s'assure de ne pas mettre le dropdown actuel dans le tableau global
        if(document.getElementById("filtreCache" + (j+1)).value != champCache.value) {
            ligneValue = document.getElementById("filtreCache" + (j+1)).value.split(" ");
            ligneValue.pop();

            //Vérifie pour chaque item dans le tableau ligne value qu'il n'est pas dans le
            //tableau global
            ligneValue.forEach(element => {
                if(tableauFiltres.includes(element) == false) {
                    //Ajouter au tableau global
                    tableauFiltres.push(element);
                }
            });
        }
    }

    // Boucle qui passe dans toutes les lignes du tableau et enlève celles qui ne correspondent pas
    // à la recherche
        if(filtre != 0) {
            //Sauvegarde les lignes qui seront cachées dans le tableau par le filtre
            for(i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByClassName("td")[colonneRecherche];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filtre) <= -1) {
                        champCache.value += i + " ";
                    }
                }
            }

            //Boucle de filtrage
            for (i = 0; i < tr.length; i++) {
                //Si la ligne est cachée par un autre filtre, on passe à la suivante
                if((lignesCachees.includes(i.toString()) == true && tableauFiltres.includes(i.toString()) == false) || tr[i].style.display != "none") {
                    td = tr[i].getElementsByClassName("td")[colonneRecherche];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filtre) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        } else {
        //Pour chaque champ caché par le filtre
        for (i = 0; i < lignesCachees.length; i++) {
            // Si la ligne cachée par le dropdown n'est pas dans le tableau alors réafficher
            if(tableauFiltres.includes(lignesCachees[i]) == false) {
                tr[lignesCachees[i]].style.display = "";
            }
            champCache.value = "";
        }
    }
}

function filtrageTexteDansColonne(colonneRecherche, id) {
    // Declaration des variables
    var textInput, filtre, table, tr, td, i, j, txtValue, champCache, lignesCachees, ligneValue, tableauFiltres = [];
    textInput = document.getElementById("filtreRechercheTextInput" + id);
    champCache = document.getElementById("filtreCache" + id);

    //Récupération des lignes déja modifiées par le filtre
    lignesCachees = champCache.value.split(" ");
    lignesCachees.pop(); //On enlève la valeur en trop à cause des espaces
    champCache.value = "";

    //Récupération de la valeur du filtre
    filtre = textInput.value.toUpperCase();

    table = document.getElementById("tableRecherche");
    tr = table.getElementsByClassName("tr");
    
    //Nombre de champs cachés sur la page
    var champCacheCount = document.querySelectorAll('.filtreCache').length;
        
    //Boucle qui passe dans tout les champs cachés pour faire un tableau de toutes les lignes 
    //des autres filtres qui sont cachées -- Chaque valeur est unique
    for(j = 0; j < champCacheCount; j++) {
        //On s'assure de ne pas mettre le textInput actuel dans le tableau global
        if(document.getElementById("filtreCache" + (j+1)).value != champCache.value) {
            ligneValue = document.getElementById("filtreCache" + (j+1)).value.split(" ");
            ligneValue.pop();

            //Vérifie pour chaque item dans le tableau ligne value qu'il n'est pas dans le
            //tableau global
            ligneValue.forEach(element => {
                if(tableauFiltres.includes(element) == false) {
                    //Ajouter au tableau global
                    tableauFiltres.push(element);
                }
            });
        }
    }

    // Boucle qui passe dans toutes les lignes du tableau et enlève celles qui ne correspondent pas
    // à la recherche
        if(filtre != 0) {
            //Sauvegarde les lignes qui seront cachées dans le tableau par le filtre
            for(i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByClassName("td")[colonneRecherche];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filtre) <= -1) {
                        champCache.value += i + " ";
                    }
                }
            }

            //Boucle de filtrage
            for (i = 0; i < tr.length; i++) {
                //Si la ligne est cachée par un autre filtre, on passe à la suivante
                if((lignesCachees.includes(i.toString()) == true && tableauFiltres.includes(i.toString()) == false) || tr[i].style.display != "none") {
                    td = tr[i].getElementsByClassName("td")[colonneRecherche];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filtre) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        } else {
        //Pour chaque champ caché par le filtre
        for (i = 0; i < lignesCachees.length; i++) {
            // Si la ligne cachée par le textInput n'est pas dans le tableau alors réafficher
            if(tableauFiltres.includes(lignesCachees[i]) == false) {
                tr[lignesCachees[i]].style.display = "";
            }
            champCache.value = "";
        }
    }
}