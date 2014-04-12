<?php
include('config.php');


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
    $_SESSION['score_cible'] = $city->cities_win_score;
}

if (!isset($_SESSION['questions'])) {
    die ('Erreur, ni ville ni questions en session');
}

# gestion de la réponse prédédente
if (isset($_SESSION['question_a_repondre'])) { // Pas pour la première question
    $duree_reponse = round( (microtime(true) - floatval($_SESSION['time_debut_question'])),0);
    unset($_SESSION['time_debut_question']);
    if ($duree_reponse >= DUREE_MAX) {
        $coef_duree = 50;
    } else {
        $coef_duree = ceil(100-($duree_reponse)*50/DUREE_MAX);
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
                $_SESSION['score'] += ceil(POINT_PAR_QUESTION*$coef_point*$coef_duree/100);
                $win = true;
            }
            break;
        case "QCM" :
            #echo intval($_POST['replyqcm'])." == ". $q_prec->questions_resp_good;
            if ( isset($_POST['replyqcm']) && intval($_POST['replyqcm']) ==  $q_prec->questions_resp_good ) {
                #echo "Point = ".POINT_PAR_QUESTION."<br/>";
                $_SESSION['score'] += ceil(POINT_PAR_QUESTION*$coef_duree/100);
                $win = true;
            }
            break;

    }

    if ($win) {
        echo "<br/><b>GOOOODDDDD : ".$_SESSION['score']." points</b>";
    } else {
        echo "<br/><b>NON toujours à : ".$_SESSION['score']." points</b>";
    }
    unset ($_SESSION['question_a_repondre']);
}

if (empty($_SESSION['questions'])) {
    # fin des question affichage du compte total
    echo "<br/>Fini le compte du score.... Alors on l'a récupéré ou pas ? <br/>";
    if ($_SESSION['score'] > $_SESSION['score_cible'] ) {
        echo "<b>WIN WIN WIN WIN </b>";
    } else {
        echo "<b>Non pas cette fois </b>";
    }
    unset($_SESSION['questions']);
} else {

    # on pose les question
    echo "<form  method='post'>";
    $numquestion = $_SESSION['nb_questions'] - count($_SESSION['questions'])  + 1;
    echo "Question n°".$numquestion."/".$_SESSION['nb_questions'];
    $_SESSION['question_a_repondre'] = array_pop($_SESSION['questions']);
    $q = new Question($_SESSION['question_a_repondre']);
    echo "QUESTION : ".$q->questions_text."<br>";
    switch ($q->questions_type) {
        case "VALUE" :
            echo "<input name='replyvalue'></input>";
            break;
        case "QCM" :
            echo '<input type="radio" name="replyqcm" value="1">'.$q->questions_resp_1."<br>";
            echo '<input type="radio" name="replyqcm" value="2">'.$q->questions_resp_2."<br>";
            if ($q->questions_resp_3) {
                echo '<input type="radio" name="replyqcm" value="3">'.$q->questions_resp_3."<br>";
            }
            break;

    }
    echo '<INPUT TYPE="submit" VALUE="Enregistrer la réponse">';
    if (count($_SESSION['questions'])) {
        echo "Encore ".count($_SESSION['questions'])." questions";
    }
    $pourcent = round($_SESSION['score']/$_SESSION['score_cible']*100)-1;
    if ($pourcent<0) $pourcent = 0;
    echo "<br/>Vous êtes à ".$pourcent."% de l'objectif";
    echo "</form>";
    $_SESSION['time_debut_question'] = microtime(true);
}


#var_dump(Question::getQuestions('ROUEN',3));