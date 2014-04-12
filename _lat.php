<?php
include('includes/config.php');

global $con;

$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ajout lat / long sur les ville

# création d'un tableau ville contre ville
$query = $con->query("select * from com1, com2 WHERE com1.`code_com`=com2.`idinsee`");


$r = $con->prepare("UPDATE cities  SET cities_lat=:cities_lat, cities_long=:cities_long  WHERE cities_id=:cities_id");

while ($f = $query->fetch(PDO::FETCH_OBJ)) {

    $cities_id = $f->id_slug;

    $r->bindParam(':cities_id', $cities_id);
    $r->bindParam(':cities_lat', $f->lat);
    $r->bindParam(':cities_long', $f->long);
    $r->execute();

}