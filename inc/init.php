<?php
//CONNECTION BDD
try {

    $type_bdd ="mysql";
    $host ="localhost";
    $dbname ="php_compte";
    $username="root";
    $password="";
    $option =[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // ici je defini que le mode de récupération de données par defaults sera sous associative
    ];

    $bdd= new PDO("$type_bdd:host=$host;dbname=$dbname", $username, $password, $option);

} catch (Exception $e) {
    die("ERROR CONNECTION BDD :" . $e ->getMessage());
}

require_once "function.php";

//declaration des variables globales
$errorMessage="";
$successMessage="";