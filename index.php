<?php

include('includes/config.php');

$user = $_SESSION['user'];

// reset questions
unset($_SESSION['questions']);


// cities list
$cities = City::getAllCities(1000);

$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array(
    'user' => $user,
    'cities' => $cities
));
