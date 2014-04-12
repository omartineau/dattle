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

/* CREA SLUG

$query = $con->query("SELECT * FROM com1");

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
}
*/

## Initialisation de la table Cities

/*$query = $con->query("SELECT * FROM com1");

while ($f = $query->fetch(PDO::FETCH_OBJ)) {
echo $f->id_slug.":".($f->population*1000)."<br/>";
    $pop = floatval(str_replace(",",".",$f->population))*1000;
    if ($pop > 100000) {
        $cities_class = "METRO";
    } elseif ($pop > 10000) {
        $cities_class = "BIG";
    } elseif ($pop > 1000) {
        $cities_class = "MEDIUM";
    } else {
        $cities_class = "SMALL";
    }
echo "INSERT INTO cities (cities_id, cities_name, cities_class, cities_population) VALUES ('".
    $f->id_slug."','".$f->Nom_com."','".$cities_class."','".$pop."')"."<br/>";
    $con->query("INSERT INTO cities (cities_id, cities_name, cities_class, cities_population) VALUES ('".
        $f->id_slug."','".$f->Nom_com."','".$cities_class."','".$pop."')");

}*/

## Création de QCM Nom d'habitant

$query = $con->query("SELECT * FROM com1");

while ($f = $query->fetch(PDO::FETCH_OBJ)) {

    $pop = floatval(str_replace(",",".",$f->population))*1000;




    if ($pop > 100000) {
        $cities_class = "METRO";
    } elseif ($pop > 10000) {
        $cities_class = "BIG";
    } elseif ($pop > 1000) {
        $cities_class = "MEDIUM";
    } else {
        $cities_class = "SMALL";
    }
echo "INSERT INTO cities (cities_id, cities_name, cities_class, cities_population) VALUES ('".
    $f->id_slug."','".$f->Nom_com."','".$cities_class."','".$pop."')"."<br/>";
    $con->query("INSERT INTO cities (cities_id, cities_name, cities_class, cities_population) VALUES ('".
        $f->id_slug."','".$f->Nom_com."','".$cities_class."','".$pop."')");

}