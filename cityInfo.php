<?php

if (!empty($_GET['city']))
{
    include('includes/config.php');

    $template = $twig->loadTemplate('cityInfo.html.twig');

    $cityOwned = false;
    $cityFree  = true;
    $city = new City($_GET['city']);

var_dump($city);

    if ($city->users_id == 0)
    {
        $cityFree = false;
    }
    elseif ($city->users_id == $_SESSION['user']->users_id)
    {
        $cityOwned = true;
    }

    $owner = new User($city->users_id);

    echo $template->render(array(
        'city'  => $city,
        'owner' => $owner,
        'questions' => $city_questions_count[$city->cities_class],
        'cityFree' => $cityFree,
        'cityOwned' => $cityOwned
    ));
}
else
{
    die("No city");
}






