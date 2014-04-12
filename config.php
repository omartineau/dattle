<?php
#    define('MYSQL_DB','dattle');
include ('classes/question.class.php');
include ('classes/user.class.php');


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

