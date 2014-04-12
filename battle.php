<?php
include('includes/config.php');

$tpl = array();

# initialisation du questionnaire
if (!empty($_GET['city']) && !isset($_SESSION['questions']) ) {
    $city = new City($_GET['city']);
    if (empty($city->cities_id)) {
        die ('Ville non trouvé');
    }
    # on charge une nouvelle série de question
    if (!isset($city_questions_count[$city->cities_class])) {
        die ('Classe de la ville inconu');
    }
    $_SESSION['questions'] = Question::getQuestions($city->cities_id,$city_questions_count[$city->cities_class]);
    $_SESSION['nb_questions'] = $city_questions_count[$city->cities_class];
    $_SESSION['score'] = 0;
    $_SESSION['score_cible'] = ($city->cities_win_score?$city->cities_win_score:50);
}

if (!isset($_SESSION['questions'])) {
    die ('Erreur, ni ville ni questions en session');
}

# gestion de la réponse prédédente
if (isset($_SESSION['question_a_repondre'])) { // Pas pour la première question
    $duree_reponse = round( (microtime(true) - floatval($_SESSION['time_debut_question'])),0);
    unset($_SESSION['time_debut_question']);
    if ($duree_reponse >= DUREE_MAX) {
        $coef_point = 50;
    } else {
        $coef_point = ceil(100-($duree_reponse)*50/DUREE_MAX);
    }
    $q_prec = new Question($_SESSION['question_a_repondre']);
    $win = false;
    switch ($q_prec->questions_type) {
        case "VALUE" :
            if ( isset($_POST['replyvalue']) &&
                 intval($_POST['replyvalue']) <  $q_prec->questions_resp_1*(1+MARGE_ERREUR) &&
                 intval($_POST['replyvalue']) >  $q_prec->questions_resp_1*(1-MARGE_ERREUR)
            ) {
                #echo intval($_POST['replyvalue']) ."-". $q_prec->questions_resp_1 ."/". $q_prec->questions_resp_1."*".MARGE_ERREUR;
                $coef_point = 1 - abs( intval($_POST['replyvalue']) - $q_prec->questions_resp_1) / ($q_prec->questions_resp_1*MARGE_ERREUR) ;
                #echo "coef point = ".$coef_point."<br/>";
                $_SESSION['score'] += ceil(POINT_PAR_QUESTION*$coef_point);
                $win = true;
            }
            break;
        case "QCM" :
            #echo intval($_POST['replyqcm'])." == ". $q_prec->questions_resp_good;
            if ( isset($_POST['replyqcm']) && intval($_POST['replyqcm']) ==  $q_prec->questions_resp_good ) {
                #echo "Point = ".POINT_PAR_QUESTION."<br/>";
                $_SESSION['score'] += ceil(POINT_PAR_QUESTION*$coef_point/100);
                $win = true;
            }
            break;

    }

    if ($win) {
        $tpl['objectif']['question_win'] = true;
        ###echo "<br/><b>GOOOODDDDD : ".$_SESSION['score']." points</b>";
    } else {
        $tpl['objectif']['question_win'] = false;
        ###echo "<br/><b>NON toujours à : ".$_SESSION['score']." points</b>";
    }
    unset ($_SESSION['question_a_repondre']);
}

if (empty($_SESSION['questions'])) {
    $tpl['objectif']['fini'] = true;
    # fin des question affichage du compte total
    ###echo "<br/>Fini le compte du score.... Alors on l'a récupéré ou pas ? <br/>";
    if ($_SESSION['score'] > $_SESSION['score_cible'] ) {
        $tpl['objectif']['ville_win'] = true;

        ###echo "<b>WIN WIN WIN WIN </b>";
    } else {
        $tpl['objectif']['ville_win'] = false;
        ###echo "<b>Non pas cette fois </b>";
    }
    unset($_SESSION['questions']);
    $q = null; // initialisation mini pour twig
} else {
    $tpl['objectif']['fini'] = false;

    # on pose les question
    ###echo "<form  method='post'>";
    $numquestion = $_SESSION['nb_questions'] - count($_SESSION['questions'])  + 1;
    $tpl['objectif']['num_quest'] = $numquestion;
    ###echo "Question n°".$numquestion."/".$_SESSION['nb_questions'];
    $_SESSION['question_a_repondre'] = array_pop($_SESSION['questions']);
    $q = new Question($_SESSION['question_a_repondre']);
    ###echo "QUESTION : ".$q->questions_text."<br>";
    switch ($q->questions_type) {
        case "VALUE" :
            ###echo "<input name='replyvalue'></input>";
            break;
        case "QCM" :
            ###echo '<input type="radio" name="replyqcm" value="1">'.$q->questions_resp_1."<br>";
            ###echo '<input type="radio" name="replyqcm" value="2">'.$q->questions_resp_2."<br>";
            if ($q->questions_resp_3) {
                ###echo '<input type="radio" name="replyqcm" value="3">'.$q->questions_resp_3."<br>";
            }
            break;

    }
    ###echo '<INPUT TYPE="submit" VALUE="Enregistrer la réponse">';
    $tpl['objectif']['nb_quest_restant'] = count($_SESSION['questions']);
    $tpl['objectif']['nb_total_quest'] =  $_SESSION['nb_questions'];
    if (count($_SESSION['questions'])) {
        ###echo "Encore ".count($_SESSION['questions'])." questions";
    }
    $pourcent = round($_SESSION['score']/$_SESSION['score_cible']*100)-1;
    if ($pourcent<0) $pourcent = 0;
    $tpl['objectif']['palier'] = $_SESSION['score_cible'];
    $tpl['objectif']['score'] = $_SESSION['score'];
    $tpl['objectif']['pourcent'] = $pourcent;

    ###echo "<br/>Vous êtes à ".$pourcent."% de l'objectif";
    ###echo "</form>";
    $_SESSION['time_debut_question'] = microtime(true);
}

$tpl['q']=$q;


$template = $twig->loadTemplate('battle.html.twig');
echo $template->render($tpl);
