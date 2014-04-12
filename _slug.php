<?php
include('includes/config.php');

global $con;

$toclean = array (
    "-LES-",
    "-LE-",
    "-LA-",
    "-LA-",
    "-DE-",
    "-DE-",
    "-L'",
    "-D'",
    "-DU-",
    "-EN-",
);

$tocleandebut = array (
    "LES ",
    "LE-",
    "LA-",
    "LA-",
    "L'-",
    "LES ",
    "LE ",
    "LA ",
    "LA ",
    "L'"
);
$tocleanfinal = array ("-", " ", "'" );

var_dump( strpos("LES AUTHIEUX-SURPORT-SAINT-OUEN","LES "));

$query = $con->query("SELECT id, Nom_com FROM com1");

while ($f = $query->fetch(PDO::FETCH_OBJ)) {
    $s = str_replace($toclean,'',strtoupper($f->Nom_com));
    foreach ($tocleandebut as $c) {
        if (strpos($s,$c)===0) {
            $s = substr($s,strlen($c));
        }
    }
    #$s = preg_replace($tocleandebut,'',$s);
    $s = str_replace($tocleanfinal,'',$s);
    echo $s."<br>";
}