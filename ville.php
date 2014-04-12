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
}

if (!isset($_SESSION['questions'])) {
    die ('Erreur, ni ville ni questions en session');
}


if (empty($_SESSION['questions'])) {
    # fin des question affichage du compte total
    echo "Fini le compte du score.... ";
    unset($_SESSION['questions']);
} else {
    # gestion de la réponse prédédente
    $dure_reponse = round( (microtime() - $_SESSION['time_debut_question'])/1000000,0);
    unset($_SESSION['time_debut_question']);
    $coef_point = 100-(DUREE_MAX-$dure_reponse)*50/15;

    $q_prec = new Question($_SESSION['question_a_repondre']);
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
    echo "</form>";
    $_SESSION['time_debut_question'] = microtime();
}


#var_dump(Question::getQuestions('ROUEN',3));