<?php
#    define('MYSQL_DB','dattle');
    include ('classes/question.class.php');

    include('db.php');
    try {
        $con = new PDO( 'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';port='.MYSQL_PORT.';', MYSQL_USER, MYSQL_PASS );
    } catch ( Exception $e ) {
        echo "Connection à MySQL impossible : ", $e->getMessage();
        die();
    }