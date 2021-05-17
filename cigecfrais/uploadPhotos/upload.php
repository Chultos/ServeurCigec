<?php
    //Récupère les photos envoyées sur le serveur et les stocke dans le fichier /cigecfrais/uploadPhotos/Photos
    move_uploaded_file($_FILES['photo']['tmp_name'], './photos/' . $_FILES['photo']['name']);
?>
