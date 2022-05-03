<?php
$host = "piasvg.mysql.database.azure.com";
    $user = "chickentikkamasala";
    $passw = "Kylling0980";
    $db = "chickentikkamasala";

    $kobling = new \mysqli($host, $user, $passw, $db);

    if ($kobling->connect_error) {
        die("Noe gikk galt: " . $kobling->connect_error);
    } else {
        
    }
?>