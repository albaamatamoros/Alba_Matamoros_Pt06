<?php
//Alba Matamoros Morales
require_once __DIR__ . '/../env.php';
//CONNEXIO
    function connexio(){
    //Dades connexio a BD.
    $host = DB_HOST;
    $nomBD = DB_NAME;
    $usuari = DB_USER;
    $contra = DB_PASS;

    //Connexió.
    try {
        $connexio = new PDO("mysql:host=$host;dbname=$nomBD;charset=utf8", $usuari, $contra);
        return $connexio;
        //echo "Connexio correcta!!" . "<br />"; 
    } catch (PDOException $e){
        die("Error: " . $e->getMessage());
    }
    }
?>