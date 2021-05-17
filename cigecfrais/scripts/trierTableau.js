//Fonction qui permet de cliquer sur les titres des colonnes pour trier un tableau
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("sorTable");
  switching = true;
  // Change le tri en mode croissant:
  dir = "asc";
  // Boucle qui permet de trier le tableau:
  while (switching) {
    // Préparation des variables:
    switching = false;
    rows = table.rows;
    // Boucle qui passe dans toutes les lignes (sauf la premier car c'est le header):
    for (i = 1; i < (rows.length - 1); i++) {
      // Préparation des variables:
      shouldSwitch = false;

      // Prends 2 éléments à comparer
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];

      // Vérifie si l'ordre des deux éléments est bon en fonction du mode de tri
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      // Si il y a besoin de changer l'ordre, le faire et marquer que le changement est fait
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Compte le nombre de changements
      switchcount ++;
    } else {
      // Si il n'y a pas eu de changement et que le mode était croissant alors 
      // refaire la boucle en mode décroissant
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}