<?php
header("Content-Type: text/html; charset=UTF-8");
include ('classes/question.class.php');
include ('classes/city.class.php');
include ('classes/user.class.php');

session_start();

include('db.php');
try {
    $con = new PDO( 'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';port='.MYSQL_PORT.';', MYSQL_USER, MYSQL_PASS );
} catch ( Exception $e ) {
    echo "Connection à MySQL impossible : ", $e->getMessage();
    die();
}

// Load Twig
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();

// Init Twig
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array());

// use
// $template = $twig->loadTemplate('template.html.twig');
// echo $template->render(array('name' => 'toto'));



# Paramètre de jeux
define('DUREE_MAX', 15); // 15 secondes pour répondre
define('POINT_PAR_QUESTION', 20); // 20 points sur chaque question
define('MARGE_ERREUR', 0.5); // 50% de marge d'erreur sur les réponses

# nombre de questions en fonction de la classe de la ville
$city_questions_count = array (
    'METRO' => 10,
    'BIG'=> 7,
    'MEDIUM'=> 5,
    'SMALL'=> 3
);
