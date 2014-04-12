<?php

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
