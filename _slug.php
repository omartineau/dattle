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


$query = $con->query("SELECT id, Nom_com FROM com1");


/* CREA SLUG
while ($f = $query->fetch(PDO::FETCH_OBJ)) {
    $s = str_replace($toclean,'',strtoupper($f->Nom_com));
    foreach ($tocleandebut as $c) {
        if (strpos($s,$c)===0) {
            $s = substr($s,strlen($c));
        }
    }
    #$s = preg_replace($tocleandebut,'',$s);
    $s = str_replace($tocleanfinal,'',$s);
    echo "UPDATE com1 SET id_slug = '".$s."' WHERE id =  ".$f->id."<br>";
    $con->query("UPDATE com1 SET id_slug = '".$s."' WHERE id =  ".$f->id);
} */

## Initialisation de la table Cities
while ($f = $query->fetch(PDO::FETCH_OBJ)) {

    if ($f->population > 100000) {
        $cities_class = "METRO";
    } elseif ($f->population > 10000) {
        $cities_class = "BIG";
    } elseif ($f->population > 1000) {
        $cities_class = "MEDIUM";
    } else {
        $cities_class = "SMALL";
    }

    $con->query("INSERT INTO (cities_id, cities_name, cities_class, cities_polulation) VALUES ('".
        $f->id_slug."','".$f->Nom_com."','".$cities_class."','".$f->population."');

}