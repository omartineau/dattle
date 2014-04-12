<?php
include('includes/config.php');

echo "<pre>";

// $user->Auth('olivier@cigogne.net', 'pwd');

var_dump($user);
echo "\n";

echo "Get user cities\n";
$cities = City::getUserCities($user->users_id);
foreach ($cities as $c)
{
    $city = new City($c);
    var_dump($city);
}


echo "</pre>";
