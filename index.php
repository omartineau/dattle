<?php

include('includes/config.php');

$user = $_SESSION['user'];


// cities list
$cities = City::getAllCities(100);

$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array(
    'user' => $user,
    'cities' => $cities
));
