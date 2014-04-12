<?php
include('includes/config.php');

global $con;

$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
/*
$query = $con->query("SELECT * FROM com1");

$r = $con->prepare("INSERT INTO cities (cities_id, cities_name, cities_class, cities_population) VALUES (:cities_id, :cities_name, :cities_class, :cities_population)");


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


    $r->bindParam(':cities_name', $f->Nom_com);
    $r->bindParam(':cities_id', $f->id_slug);
    $r->bindParam(':cities_class', $cities_class);
    $r->bindParam(':cities_population', $pop, PDO::PARAM_INT);
    $r->execute();

echo $f->id_slug."<br/>";


}
*/
## Création de QCM Nom d'habitant

$questions_datasource = "COMMUNE/QCMHAB";
$questions_type = "QCM";
$query = $con->query("SELECT * FROM com1");
$r = $con->prepare("INSERT INTO questions (questions_text, questions_type, questions_resp_1, questions_resp_2,questions_resp_3,".
    " questions_resp_good,cities_id,questions_datasource) VALUES (:questions_text, :questions_type, :questions_resp_1, :questions_resp_2, :questions_resp_3,:questions_resp_good, :cities_id, :questions_datasource )");

while ($f = $query->fetch(PDO::FETCH_OBJ)) {

    $pop = floatval(str_replace(",",".",$f->population))*1000;
    $pop2 = round(rand(10,100))*100;
    $pop3 = round(rand(10,100))*100;
    echo $f->id_slug . " = ". $pop."/".$pop2."/".$pop3."<br/>";

    $questions_text = "Quel est le nombre d'habitants de ".$f->Nom_com." ?";
    $cities_id = $f->id_slug;
    if (rand(1,10)> 5) {
        $questions_resp_1 = $pop;
        $questions_resp_2 = $pop2;
        $questions_resp_3 = $pop3;
        $questions_resp_good = 1;
    } else {
        $questions_resp_1 = $pop3;
        $questions_resp_2 = $pop;
        $questions_resp_3 = $pop2;
        $questions_resp_good = 2;
    }

    $r->bindParam(':questions_text', $questions_text);
    $r->bindParam(':questions_type', $questions_type);
    $r->bindParam(':questions_resp_1', $questions_resp_1);
    $r->bindParam(':questions_resp_2', $questions_resp_2);
    $r->bindParam(':questions_resp_3', $questions_resp_3);
    $r->bindParam(':questions_resp_good', $questions_resp_good, PDO::PARAM_INT);
    $r->bindParam(':cities_id', $cities_id);
    $r->bindParam(':questions_datasource', $questions_datasource);
    $r->execute();



}


# création d'un tableau ville contre ville
$query = $con->query("SELECT * FROM com1");
$villes = array();
while ($f = $query->fetch(PDO::FETCH_OBJ)) {
    $villes[] = array(
        'nom'=>$f->Nom_com,
        'pop'=>floatval(str_replace(",",".",$f->population))*1000
    );
}

## Création de QCM  plus grand qu'une autre ville
$questions_datasource = "COMMUNE/QCMPlusdhab";
$questions_type = "QCM";
$query = $con->query("SELECT * FROM com1");
$r = $con->prepare("INSERT INTO questions (questions_text, questions_type, questions_resp_1, questions_resp_2,questions_resp_3,".
    " questions_resp_good,cities_id,questions_datasource) VALUES (:questions_text, :questions_type, :questions_resp_1, :questions_resp_2, :questions_resp_3,:questions_resp_good, :cities_id, :questions_datasource )");

while ($f = $query->fetch(PDO::FETCH_OBJ)) {

    $pop = floatval(str_replace(",",".",$f->population))*1000;
    echo $f->id_slug . " = ". $pop."<br/>";

    $concurrent = round(rand(0,733));

    $questions_text = "Est-ce que  ".$f->Nom_com." possède plus d'habitants que ".$villes[$concurrent]['nom'];

    $cities_id = $f->id_slug;
    $questions_resp_1 = $f->Nom_com." est plus grand";
    $questions_resp_2 = $villes[$concurrent]['nom']." est plus grand";
    $questions_resp_3 = null;
    if ($pop>$villes[$concurrent]['pop']) {
        $questions_resp_good = 1;
    } else {
        $questions_resp_good = 2;
    }



    $r->bindParam(':questions_text', $questions_text);
    $r->bindParam(':questions_type', $questions_type);
    $r->bindParam(':questions_resp_1', $questions_resp_1);
    $r->bindParam(':questions_resp_2', $questions_resp_2);
    $r->bindParam(':questions_resp_3', $questions_resp_3);
    $r->bindParam(':questions_resp_good', $questions_resp_good, PDO::PARAM_INT);
    $r->bindParam(':cities_id', $cities_id);
    $r->bindParam(':questions_datasource', $questions_datasource);
    $r->execute();



}