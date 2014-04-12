<?php
header("Content-Type: text/html; charset=UTF-8");

# constantes
include('includes/const.php');

# classes
include('classes/question.class.php');
include('classes/city.class.php');
include('classes/user.class.php');


# DB
include('includes/db.php');
try {
    $con = new PDO( 'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';port='.MYSQL_PORT.';', MYSQL_USER, MYSQL_PASS );
} catch ( Exception $e ) {
    echo "Connection à MySQL impossible : ", $e->getMessage();
    die();
}

# Twig
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array());
// use
// $template = $twig->loadTemplate('template.html.twig');
// echo $template->render(array('name' => 'toto'));

# session
session_start();

if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
}
else
{
    $user = new User();
    $_SESSION['user'] = $user;
}