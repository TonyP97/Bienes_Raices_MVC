<?php

function conectarDB() : mysqli {
    $db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME'], $_ENV['DB_PORT']);


    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
}
// function conectarDB() {
//     $db = pg_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);


//     if(!$db) {
//         echo "Error no se pudo conectar";
//         exit;
//     }

//     return $db;
// }