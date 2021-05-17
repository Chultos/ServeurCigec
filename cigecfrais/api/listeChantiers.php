<?php
// On précise le type de contenu retourné, ici du JSON
header("Content-Type: application/json");

echo json_encode($les_chantiers);
?>
