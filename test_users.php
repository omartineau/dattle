<?php
include('config.php');

echo "<pre>";


echo "try to auth olivier@cigogne.net:pwd\n";
$u = new User();
//$u->Create('toto@mail.com', 'pwd', 'toto');
$u->Auth('olivier@cigogne.net', 'pwd');
var_dump($u);
echo "\n";

echo "Get user cities\n";
$cities = City::getUserCities($u->users_id);
var_dump($cities);



echo "</pre>";
